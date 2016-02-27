<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 9:02
 */

namespace romkaChev\yandexFotki\interfaces\models;

use romkaChev\yandexFotki\traits\parsers\AddressBindingParser;
use romkaChev\yandexFotki\traits\parsers\AuthorParser;
use romkaChev\yandexFotki\traits\parsers\DateParser;
use romkaChev\yandexFotki\traits\parsers\ImagesParser;
use romkaChev\yandexFotki\traits\parsers\PointParser;
use yii\helpers\ArrayHelper;

/**
 * Interface IPhoto
 *
 * @package romkaChev\yandexFotki\interfaces\models
 */
abstract class AbstractPhoto extends AbstractModel implements IImageSize
{
    use AuthorParser, ImagesParser, PointParser, AddressBindingParser, DateParser;

    /** @var string */
    public $urn;
    /** @var int */
    public $id;
    /** @var AbstractAuthor */
    public $author;
    /** @var string */
    public $access;
    /** @var bool */
    public $isForAdult;
    /** @var bool */
    public $isHideOriginal;
    /** @var bool */
    public $isDisableComments;
    /** @var AbstractImage[] */
    public $images;
    /** @var AbstractPoint */
    public $point;
    /** @var AbstractAddressBinding */
    public $addressBinding;
    /** @var string */
    public $publishedAt;
    /** @var string */
    public $updatedAt;
    /** @var string */
    public $editedAt;
    /** @var string */
    public $linkSelf;
    /** @var string */
    public $linkEdit;
    /** @var string */
    public $linkAlternate;
    /** @var string */
    public $linkEditMedia;
    /** @var string */
    public $linkAlbum;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['urn', 'string'],
            ['id', 'integer'],
            ['author', $this->getYandexFotki()->getFactory()->getAuthorValidator()],
            ['access', 'string'],
            ['isForAdult', 'boolean'],
            ['isHideOriginal', 'boolean'],
            ['isDisableComments', 'boolean'],
            ['images', 'each', 'rule' => [$this->getYandexFotki()->getFactory()->getImageValidator()]],
            ['point', $this->getYandexFotki()->getFactory()->getPointValidator()],
            ['addressBinding', $this->getYandexFotki()->getFactory()->getAddressBindingValidator()],
            ['publishedAt', 'string'],
            ['updatedAt', 'string'],
            ['editedAt', 'url'],
            ['linkSelf', 'url'],
            ['linkEdit', 'url'],
            ['linkAlternate', 'url'],
            ['linkEditMedia', 'url'],
            ['linkAlbum', 'url'],
        ];
    }

    /**
     * @param array $data
     *
     * @return $this
     */
    public function loadWithData($data)
    {
        \Yii::configure($this, [
            'urn'               => ArrayHelper::getValue($data, 'id'),
            'id'                => ArrayHelper::getValue($data, $this->getIdParser()),
            'author'            => ArrayHelper::getValue($data, $this->getAuthorParser($this->getYandexFotki()->getFactory()->getAuthorModel())),
            'access'            => ArrayHelper::getValue($data, 'access'),
            'isForAdult'        => ArrayHelper::getValue($data, 'xxx', false),
            'isHideOriginal'    => ArrayHelper::getValue($data, 'hide_original', false),
            'isDisableComments' => ArrayHelper::getValue($data, 'disable_comments', false),
            'images'            => ArrayHelper::getValue($data, $this->getImagesParser($this->getYandexFotki()->getFactory()->getImageModel())),
            'point'             => ArrayHelper::getValue($data, $this->getPointParser($this->getYandexFotki()->getFactory()->getPointModel())),
            'addressBinding'    => ArrayHelper::getValue($data, $this->getAddressBindingParser($this->getYandexFotki()->getFactory()->getAddressBindingModel())),
            'publishedAt'       => ArrayHelper::getValue($data, $this->getDateParser('published')),
            'updatedAt'         => ArrayHelper::getValue($data, $this->getDateParser('updated')),
            'editedAt'          => ArrayHelper::getValue($data, $this->getDateParser('edited')),
            'linkSelf'          => ArrayHelper::getValue($data, 'links.self'),
            'linkEdit'          => ArrayHelper::getValue($data, 'links.edit'),
            'linkAlternate'     => ArrayHelper::getValue($data, 'links.alternate'),
            'linkEditMedia'     => ArrayHelper::getValue($data, 'links.edit-media'),
            'linkAlbum'         => ArrayHelper::getValue($data, 'links.album'),
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
            preg_match('/^urn:yandex:fotki:([^:]*):photo:(?<id>\d+)$/', $value, $matches);

            return intval(ArrayHelper::getValue($matches, 'id')) ?: $defaultValue;
        };
    }
}