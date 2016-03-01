<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 9:52
 */

namespace romkaChev\yandexFotki\models;

use DateTime;
use romkaChev\yandexFotki\interfaces\LoadableWithData;
use romkaChev\yandexFotki\traits\parsers\AuthorParser;
use romkaChev\yandexFotki\traits\parsers\DateParser;
use romkaChev\yandexFotki\traits\parsers\PhotosParser;
use yii\helpers\ArrayHelper;

/**
 * Class AlbumPhotosCollection
 *
 * @package romkaChev\yandexFotki\models
 */
class AlbumPhotosCollection extends AbstractModel implements LoadableWithData
{
    use AuthorParser, DateParser, PhotosParser;

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
    /** @var DateTime */
    public $updatedAt;
    /** @var string */
    public $linkSelf;
    /** @var string */
    public $linkNext;
    /** @var string */
    public $linkAlternate;
    /** @var int */
    public $imageCount;
    /** @var Photo[] */
    public $photos;

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
     * @inheritdoc
     */
    public function loadWithData($data, $fast = false)
    {
        $factory    = $this->getYandexFotki()->getFactory();
        $attributes = [
            'urn'           => ArrayHelper::getValue($data, 'id'),
            'id'            => ArrayHelper::getValue($data, $this->getIdParser()),
            'author'        => ArrayHelper::getValue($data, $this->getAuthorParser('authors.0', $factory->getAuthorModel(), $fast)),
            'title'         => ArrayHelper::getValue($data, 'title'),
            'summary'       => ArrayHelper::getValue($data, 'summary'),
            'updatedAt'     => ArrayHelper::getValue($data, $this->getDateParser('updated', $this->getYandexFotki()->getFormatter())),
            'linkSelf'      => ArrayHelper::getValue($data, 'links.self'),
            'linkNext'      => ArrayHelper::getValue($data, 'links.next'),
            'linkAlternate' => ArrayHelper::getValue($data, 'links.alternate'),
            'imageCount'    => ArrayHelper::getValue($data, 'imageCount'),
            'photos'        => ArrayHelper::getValue($data, $this->getPhotosParser('entries', $factory->getPhotoModel(), $fast))
        ];

        if ($fast) {
            \Yii::configure($this, $attributes);
        } else {
            $this->load([$this->formName() => $attributes]);
        }

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
}