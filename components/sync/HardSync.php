<?php
namespace romkaChev\yandexFotki\components\sync;

use DateTime;
use DateTimeZone;
use romkaChev\yandexFotki\models\Album;
use romkaChev\yandexFotki\models\Author;
use romkaChev\yandexFotki\models\Image;
use romkaChev\yandexFotki\models\Photo;
use romkaChev\yandexFotki\models\PhotoTag;
use romkaChev\yandexFotki\models\Tag;
use yii\base\Component;
use yii\db\Connection;
use yii\helpers\ArrayHelper;
use yii\httpclient\Client;
use yii\httpclient\Request;
use yii\i18n\Formatter;

/**
 * Class HardSync
 *
 * @package romkaChev\yandexFotki\components\sync
 *
 * @author  Roman Kulikov <flinnraider@yandex.ru>
 */
class HardSync extends Component implements SyncInterface
{
    /** @var Connection */
    public $db;
    /** @var Formatter */
    public $formatter;
    /** @var Client */
    public $httpClient;

    public $perPage = 100;

    protected $totalPhotos = null;
    
    public function sync()
    {
        $this->truncateTables();

        $this->syncAlbums();
        $this->syncPhotos();
    }

    protected function syncAlbums()
    {
        $httpClient = $this->httpClient;
        $request    = $httpClient->get("albums/rupdated/", ['format' => 'json', 'limit' => $this->perPage]);

        do {
            $data      = $this->processRequest($request);
            $rawAlbums = ArrayHelper::getValue($data, 'entries', []);

            $this->processAlbumsBatch($rawAlbums);

            $linkNext = ArrayHelper::getValue($data, 'links.next');
            $request  = $httpClient->get($linkNext);
        } while ($linkNext);
    }

    protected function processRequest(Request $request)
    {
        try {
            $response = $request->send();
            $data     = $response->getData();
        } catch (\Exception $e) {
            sleep(3);
            $response = $request->send();
            $data     = $response->getData();
        }

        return $data;
    }

    protected function processAlbumsBatch($rawAlbums)
    {
        $rows    = [];
        $columns = [
            'id',
            'authorId',
            'parentId',
            'title',
            'summary',
            'imageCount',
            'publishedAt',
            'updatedAt',
            'editedAt'
        ];

        $this->processAuthorsBatch(ArrayHelper::getColumn($rawAlbums, 'authors.0'));

        $timeZone = new DateTimeZone($this->formatter->timeZone);
        foreach ($rawAlbums as $rawAlbum) {
            $rows[] = array_values([
                //@formatter:off
                /* 'id'          => */ $this->parseAlbumIdFromUrn(ArrayHelper::getValue($rawAlbum, 'id')),
                /* 'authorId'    => */ ArrayHelper::getValue($rawAlbum, 'authors.0.uid'),
                /* 'parentId'    => */ $this->parseAlbumIdFromLink(ArrayHelper::getValue($rawAlbum, 'links.album')),
                /* 'title'       => */ ArrayHelper::getValue($rawAlbum, 'title'),
                /* 'summary'     => */ ArrayHelper::getValue($rawAlbum, 'summary'),
                /* 'imageCount'  => */ ArrayHelper::getValue($rawAlbum, 'imageCount', 0),
                /* 'publishedAt' => */ (new DateTime(ArrayHelper::getValue($rawAlbum, 'published'), $timeZone))->format('Y-m-d H:i:s'),
                /* 'updatedAt'   => */ (new DateTime(ArrayHelper::getValue($rawAlbum, 'updated'  ), $timeZone))->format('Y-m-d H:i:s'),
                /* 'editedAt'    => */ (new DateTime(ArrayHelper::getValue($rawAlbum, 'edited'   ), $timeZone))->format('Y-m-d H:i:s'),
                //@formatter:on
            ]);
        }

        $transaction = $this->db->beginTransaction();
        $this->db->createCommand()->setSql("SET foreign_key_checks = 0")->execute();
        $this->db->createCommand()->batchInsert(Album::tableName(), $columns, $rows)->execute();
        $this->db->createCommand()->setSql("SET foreign_key_checks = 1")->execute();

        $transaction->commit();
    }

    protected function syncPhotos()
    {
        $httpClient = $this->httpClient;
        $request    = $httpClient->get("photos/rupdated/", ['format' => 'json', 'limit' => $this->perPage]);

        do {
            $data      = $this->processRequest($request);
            $rawPhotos = ArrayHelper::getValue($data, 'entries', []);

            $this->processPhotosBatch($rawPhotos);

            $linkNext = ArrayHelper::getValue($data, 'links.next');
            $request  = $httpClient->get($linkNext);
        } while ($linkNext);
    }

    protected function processPhotosBatch($rawPhotos)
    {
        $rows    = [];
        $columns = [
            'id',
            'authorId',
            'albumId',
            'accessId',
            'title',
            'summary',
            'latitude',
            'longitude',
            'isAdultsOnly',
            'isOriginalHidden',
            'isCommentsDisabled',
            'publishedAt',
            'updatedAt',
            'editedAt',
        ];

        $this->processAuthorsBatch(ArrayHelper::getColumn($rawPhotos, 'authors.0'));

        $tagsBatch   = [];
        $imagesBatch = [];

        $timeZone = new DateTimeZone($this->formatter->timeZone);
        foreach ($rawPhotos as $rawPhoto) {
            $photoId  = $this->parsePhotoIdFromUrn(ArrayHelper::getValue($rawPhoto, 'id'));
            $authorId = ArrayHelper::getValue($rawPhoto, 'authors.0.uid');

            if (($stringCoordinates = ArrayHelper::getValue($rawPhoto, 'geo.coordinates', null)) !== null) {
                $coordinates = array_map('floatval', explode(' ', $stringCoordinates));
            } else {
                $coordinates = [];
            }

            $images = ArrayHelper::getValue($rawPhoto, 'img', []);
            $tags   = ArrayHelper::getValue($rawPhoto, 'tags', []);

            foreach ($images as $sizeId => $image) {
                $imagesBatch[] = [
                    //@formatter:off
                    /* 'photoId'  => */ $photoId,
                    /* 'sizeId'   => */ $sizeId,
                    /* 'width'    => */ ArrayHelper::getValue($image,'width'),
                    /* 'height'   => */ ArrayHelper::getValue($image,'height'),
                    /* 'bytesize' => */ ArrayHelper::getValue($image,'bytesize'),
                    /* 'href'     => */ ArrayHelper::getValue($image,'href'),
                    //@formatter:on
                ];
            }

            foreach ($tags as $tagId => $href) {
                $tagsBatch[] = [
                    //@formatter:off
                    /* 'id'      => */ $tagId,
                    /* 'photoId' => */ $authorId,
                    /* 'photoId' => */ $photoId,
                    //@formatter:on
                ];
            }

            $rows[] = array_values([
                //@formatter:off
                /* 'id'                 => */ $photoId,
                /* 'authorId'           => */ $authorId,
                /* 'albumId'            => */ $this->parseAlbumIdFromLink(ArrayHelper::getValue($rawPhoto, 'links.album')),
                /* 'accessId'           => */ ArrayHelper::getValue($rawPhoto, 'access'),
                /* 'title'              => */ ArrayHelper::getValue($rawPhoto, 'title'),
                /* 'summary'            => */ ArrayHelper::getValue($rawPhoto, 'summary'),
                /* 'latitude'           => */ ArrayHelper::getValue($coordinates, 0),
                /* 'longitude'          => */ ArrayHelper::getValue($coordinates, 1),
                /* 'isAdultsOnly'       => */ ArrayHelper::getValue($rawPhoto, 'xxx', false),
                /* 'isOriginalHidden'   => */ ArrayHelper::getValue($rawPhoto, 'hide_original', false),
                /* 'isCommentsDisabled' => */ ArrayHelper::getValue($rawPhoto, 'disable_comments', false),
                /* 'publishedAt'        => */ (new DateTime(ArrayHelper::getValue($rawPhoto, 'published'), $timeZone))->format('Y-m-d H:i:s'),
                /* 'updatedAt'          => */ (new DateTime(ArrayHelper::getValue($rawPhoto, 'updated'  ), $timeZone))->format('Y-m-d H:i:s'),
                /* 'editedAt'           => */ (new DateTime(ArrayHelper::getValue($rawPhoto, 'edited'   ), $timeZone))->format('Y-m-d H:i:s'),
                //@formatter:on
            ]);
        }

        $transaction = $this->db->beginTransaction();
        $this->db->createCommand()->setSql("SET foreign_key_checks = 0")->execute();
        $this->db->createCommand()->batchInsert(Photo::tableName(), $columns, $rows)->execute();
        $this->db->createCommand()->setSql("SET foreign_key_checks = 1")->execute();
        $transaction->commit();

        $this->processImagesBatch($imagesBatch);
        $this->processTagsBatch($tagsBatch);
    }

    protected function processImagesBatch($rows)
    {
        $columns = [
            'photoId',
            'sizeId',
            'width',
            'height',
            'byteSize',
            'href',
        ];

        if (!empty($rows)) {
            $transaction = $this->db->beginTransaction();
            $this->db->createCommand()->setSql("SET foreign_key_checks = 0")->execute();
            $this->db->createCommand()->batchInsert(Image::tableName(), $columns, $rows)->execute();
            $this->db->createCommand()->setSql("SET foreign_key_checks = 1")->execute();
            $transaction->commit();
        }
    }

    protected function processAuthorsBatch($rawAuthors)
    {
        $rawAuthors = array_unique($rawAuthors, SORT_REGULAR);
        $rawAuthors = ArrayHelper::index($rawAuthors, 'uid');

        $availableIds = Author::find()->select(['id'])->column();

        $rows = [];

        foreach ($rawAuthors as $rawAuthor) {
            if (in_array($rawAuthor['uid'], $availableIds)) {
                continue;
            }

            $rows[] = array_values([
                //@formatter:off
                /* 'id'   => */ $rawAuthor['uid'],
                /* 'name' => */ $rawAuthor['name'],
                //@formatter:on
            ]);
        }

        if (!empty($rows)) {
            $this->db->createCommand()
                ->batchInsert(
                    Author::tableName(),
                    ['id', 'name'],
                    $rows
                )
                ->execute();
        }
    }

    protected function processTagsBatch($rawTags)
    {
        $columns = [
            'id',
            'authorId',
        ];

        $availableIds = Tag::find()->select(['id'])->column();

        $rows = array_map(function ($rawTag) use ($availableIds) {
            if (in_array($rawTag[0], $availableIds)) {
                return null;
            }

            return [$rawTag[0], $rawTag[1]];
        }, $rawTags);

        $rows = array_filter($rows);
        $rows = array_unique($rows, SORT_REGULAR);

        if (!empty($rows)) {
            $transaction = $this->db->beginTransaction();
            $this->db->createCommand()->setSql("SET foreign_key_checks = 0")->execute();
            $this->db->createCommand()->batchInsert(Tag::tableName(), $columns, $rows)->execute();
            $this->db->createCommand()->setSql("SET foreign_key_checks = 1")->execute();
            $transaction->commit();
        }

        $columns = ['tagId', 'photoId'];

        $rows = array_map(function ($rawTag) {
            return [$rawTag[0], $rawTag[2]];
        }, $rawTags);

        if (count($rawTags)) {
            $transaction = $this->db->beginTransaction();
            $this->db->createCommand()->setSql("SET foreign_key_checks = 0")->execute();
            $this->db->createCommand()->batchInsert(PhotoTag::tableName(), $columns, $rows)->execute();
            $this->db->createCommand()->setSql("SET foreign_key_checks = 1")->execute();
            $transaction->commit();
        }
    }

    protected function truncateTables()
    {
        $transaction = $this->db->beginTransaction();

        $this->db->createCommand()->setSql("SET foreign_key_checks = 0")->execute();
        $this->db->createCommand()->truncateTable(PhotoTag::tableName())->execute();
        $this->db->createCommand()->truncateTable(Tag::tableName())->execute();
        $this->db->createCommand()->truncateTable(Image::tableName())->execute();
        $this->db->createCommand()->truncateTable(Photo::tableName())->execute();
        $this->db->createCommand()->truncateTable(Album::tableName())->execute();
        $this->db->createCommand()->truncateTable(Author::tableName())->execute();
        $this->db->createCommand()->setSql("SET foreign_key_checks = 1")->execute();

        $transaction->commit();
    }

    /**
     * @param string $link
     *
     * @return integer|null
     */
    protected function parseAlbumIdFromLink($link)
    {
        preg_match('/.*\/users\/([^\/]*)\/album\/(?<albumId>[^\/]*)/', $link, $matches);

        return intval(ArrayHelper::getValue($matches, 'albumId')) ?: null;
    }

    /**
     * @param string $urn
     *
     * @return integer|null
     */
    protected function parseAlbumIdFromUrn($urn)
    {
        preg_match('/^urn:yandex:fotki:([^:]*):album:(?<id>\d+)$/', $urn, $matches);

        return intval(ArrayHelper::getValue($matches, 'id')) ?: null;
    }

    /**
     * @param string $urn
     *
     * @return integer|null
     */
    protected function parsePhotoIdFromUrn($urn)
    {
        preg_match('/^urn:yandex:fotki:([^:]*):photo:(?<id>\d+)$/', $urn, $matches);

        return intval(ArrayHelper::getValue($matches, 'id')) ?: null;
    }
}