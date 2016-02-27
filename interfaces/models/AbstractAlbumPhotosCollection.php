<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 9:52
 */

namespace romkaChev\yandexFotki\interfaces\models;

use romkaChev\yandexFotki\traits\parsers\AuthorParser;
use romkaChev\yandexFotki\traits\parsers\DateParser;
use romkaChev\yandexFotki\traits\parsers\PhotosParser;
use yii\helpers\ArrayHelper;

/**
 * Class AbstractAlbumPhotosCollection
 *
 * @package romkaChev\yandexFotki\interfaces\models
 */
abstract class AbstractAlbumPhotosCollection extends AbstractModel
{
    use AuthorParser, DateParser, PhotosParser;

    /** @var string */
    public $urn;
    /** @var int */
    public $id;
    /** @var AbstractAuthor */
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
    /** @var AbstractPhoto[] */
    protected $photos;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['urn', 'string'],
            ['id', 'integer'],
            ['author', $this->getYandexFotki()->getFactory()->getAuthorValidator()],
            ['title', 'string'],
            ['summary', 'string'],
            ['updatedAt', 'string'],
            ['linkSelf', 'url'],
            ['linkNext', 'url'],
            ['linkAlternate', 'url'],
            ['photos', 'each', 'rule' => [$this->getYandexFotki()->getFactory()->getPhotoValidator()]]
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
            'author'        => ArrayHelper::getValue($data, $this->getAuthorParser($this->getYandexFotki()->getFactory()->getAuthorModel())),
            'title'         => ArrayHelper::getValue($data, 'title'),
            'summary'       => ArrayHelper::getValue($data, 'summary'),
            'updatedAt'     => ArrayHelper::getValue($data, $this->getDateParser('updated')),
            'linkSelf'      => ArrayHelper::getValue($data, 'links.self'),
            'linkNext'      => ArrayHelper::getValue($data, 'links.next'),
            'linkAlternate' => ArrayHelper::getValue($data, 'links.alternate'),
            'imageCount'    => ArrayHelper::getValue($data, 'imageCount'),
            'photos'        => ArrayHelper::getValue($data, $this->getPhotosParser($this->getYandexFotki()->getFactory()->getPhotoModel()))
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
     * @param AbstractPhoto[] $photos
     */
    public function setPhotos($photos)
    {
        $this->photos = $photos;
    }
}