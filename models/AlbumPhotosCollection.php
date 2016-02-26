<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 26.02.2016
 * Time: 17:59
 */

namespace romkaChev\yandexFotki\models;


use romkaChev\yandexFotki\interfaces\models\IAlbumPhotosCollection;
use romkaChev\yandexFotki\interfaces\models\IPhoto;
use romkaChev\yandexFotki\traits\parsers\AuthorParser;
use romkaChev\yandexFotki\traits\parsers\DateParser;
use romkaChev\yandexFotki\traits\parsers\PhotosParser;
use romkaChev\yandexFotki\traits\YandexFotkiAccess;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Class AlbumPhotosCollection
 *
 * @package romkaChev\yandexFotki\models
 */
class AlbumPhotosCollection extends Model implements IAlbumPhotosCollection
{
    use YandexFotkiAccess, AuthorParser, DateParser, PhotosParser;

    /** @var string */
    public $urn;
    /** @var int */
    public $id;
    /** @var Author */
    public $author;
    /** @var string */
    public $title;
    /** @var string */
    public $summary;
    /** @var string */
    public $updatedAt;
    /** @var string */
    public $linkSelf;
    /** @var string */
    public $linkNext;
    /** @var string */
    public $linkAlternate;
    /** @var int */
    public $imageCount;
    /** @var IPhoto[] */
    protected $photos;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['urn', 'string'],
            ['id', 'integer'],
            ['author', $this->yandexFotki->authorValidator],
            ['title', 'string'],
            ['summary', 'string'],
            ['updatedAt', 'string'],
            ['linkSelf', 'url'],
            ['linkNext', 'url'],
            ['linkAlternate', 'url'],
            ['photos', 'each', 'rule' => [$this->yandexFotki->photoValidator]]
        ];
    }

    /**
     * @param array $data
     *
     * @return static
     */
    public function loadWithData($data)
    {
        \Yii::configure($this, [
            'urn'           => ArrayHelper::getValue($data, 'id'),
            'id'            => ArrayHelper::getValue($data, $this->getIdParser()),
            'author'        => ArrayHelper::getValue($data, $this->getAuthorParser($this->yandexFotki->authorModel)),
            'title'         => ArrayHelper::getValue($data, 'title'),
            'summary'       => ArrayHelper::getValue($data, 'summary'),
            'updatedAt'     => ArrayHelper::getValue($data, $this->getDateParser('updated')),
            'linkSelf'      => ArrayHelper::getValue($data, 'links.self'),
            'linkNext'      => ArrayHelper::getValue($data, 'links.next'),
            'linkAlternate' => ArrayHelper::getValue($data, 'links.alternate'),
            'imageCount'    => ArrayHelper::getValue($data, 'imageCount'),
            'photos'        => ArrayHelper::getValue($data, $this->getPhotosParser($this->yandexFotki->photoModel))
        ]);

        return $this;
    }

    /**
     * @return \Closure
     */
    public function getIdParser()
    {
        /**
         * @param $array
         * @param $defaultValue
         *
         * @return mixed
         */
        return function ($array, $defaultValue) {
            $value = ArrayHelper::getValue($array, 'id');
            preg_match('/^urn:yandex:fotki:([^:]*):album:(?<id>\d+)$/', $value, $matches);

            return intval(ArrayHelper::getValue($matches, 'id')) ?: $defaultValue;
        };
    }

    /**
     * @inheritdoc
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * @param IPhoto[] $photos
     */
    public function setPhotos($photos)
    {
        $this->photos = $photos;
    }
}