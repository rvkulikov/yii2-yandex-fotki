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

    public function sync()
    {
        $this->truncateTables();

        $this->syncAlbums();
        $this->syncPhotos();
    }

    private function syncAlbums()
    {
        $httpClient = $this->httpClient;
        $request    = $httpClient->get("albums/updated/", ['format' => 'json', 'limit' => $this->perPage]);

        do {
            $data      = $this->processRequest($request);
            $rawAlbums = ArrayHelper::getValue($data, 'entries', []);

            $this->processAlbumsBatch($rawAlbums);

            $linkNext = ArrayHelper::getValue($data, 'links.next');
            $request  = $httpClient->get($linkNext);
        } while ($linkNext);
    }

    private function processRequest(Request $request)
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

    private function processAlbumsBatch($rawAlbums)
    {
        $rows    = [];
        $columns = [
            'id',
            'authorId',
            'parentId',
            'title',
            'summary',
            'publishedAt',
            'updatedAt',
            'editedAt'
        ];

        $this->processAuthorsBatch(ArrayHelper::getColumn($rawAlbums, 'authors.0'));

        $timeZone = new DateTimeZone($this->formatter->timeZone);
        foreach ($rawAlbums as $rawAlbum) {
            $rows[$this->parseAlbumIdFromUrn(ArrayHelper::getValue($rawAlbum, 'id'))] = [
                //@formatter:off
                /* 'id'          => */ $this->parseAlbumIdFromUrn(ArrayHelper::getValue($rawAlbum, 'id')),
                /* 'authorId'    => */ ArrayHelper::getValue($rawAlbum, 'authors.0.uid'),
                /* 'parentId'    => */ $this->parseAlbumIdFromLink(ArrayHelper::getValue($rawAlbum, 'links.album')),
                /* 'title'       => */ ArrayHelper::getValue($rawAlbum, 'title'),
                /* 'summary'     => */ ArrayHelper::getValue($rawAlbum, 'summary'),
                /* 'publishedAt' => */ (new DateTime(ArrayHelper::getValue($rawAlbum, 'published'), $timeZone))->format('Y-m-d H:i:s'),
                /* 'updatedAt'   => */ (new DateTime(ArrayHelper::getValue($rawAlbum, 'updated'  ), $timeZone))->format('Y-m-d H:i:s'),
                /* 'editedAt'    => */ (new DateTime(ArrayHelper::getValue($rawAlbum, 'edited'   ), $timeZone))->format('Y-m-d H:i:s'),
                //@formatter:on
            ];
        }

        $transaction = $this->db->beginTransaction();
        $this->db->createCommand()->setSql("SET foreign_key_checks = 0")->execute();
        $this->db->createCommand()->batchInsert(Album::tableName(), $columns, $rows)->execute();
        $this->db->createCommand()->setSql("SET foreign_key_checks = 1")->execute();

        $transaction->commit();
    }

    private function processAuthorsBatch($rawAuthors)
    {
        $rawAuthors = array_unique($rawAuthors, SORT_REGULAR);
        $rawAuthors = ArrayHelper::index($rawAuthors, 'uid');

        $availableIds = Author::find()->select(['id'])->column();

        $rows = [];

        foreach ($rawAuthors as $rawAuthor) {
            if (in_array($rawAuthor['uid'], $availableIds)) {
                continue;
            }

            $rows[] = [
                //@formatter:off
                /* 'id'   => */ $rawAuthor['uid'],
                /* 'name' => */ $rawAuthor['name'],
                //@formatter:on
            ];
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

    private function syncPhotos()
    {

    }

    private function truncateTables()
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
    private function parseAlbumIdFromLink($link)
    {
        preg_match('/.*\/users\/([^\/]*)\/album\/(?<albumId>[^\/]*)/', $link, $matches);

        return intval(ArrayHelper::getValue($matches, 'albumId')) ?: null;
    }

    /**
     * @param string $urn
     *
     * @return integer|null
     */
    private function parseAlbumIdFromUrn($urn)
    {
        preg_match('/^urn:yandex:fotki:([^:]*):album:(?<id>\d+)$/', $urn, $matches);

        return intval(ArrayHelper::getValue($matches, 'id')) ?: null;
    }
}