<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 18.12.2015
 * Time: 22:43
 */

namespace romkaChev\yandexFotki\models;


use romkaChev\yandexFotki\interfaces\models\IPhoto;
use romkaChev\yandexFotki\traits\YandexFotkiAccess;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class Photo extends Model implements IPhoto
{
    use YandexFotkiAccess;

    /** @var string */
    public $urn;
    /** @var int */
    public $id;
    /** @var Author */
    public $author;
    /** @var string */
    public $access;
    /** @var bool */
    public $isForAdult;
    /** @var bool */
    public $isHideOriginal;
    /** @var bool */
    public $isDisableComments;
    /** @var Image[] */
    public $images;
    /** @var Point */
    public $point;
    /** @var AddressBinding */
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

    public function rules()
    {
        return [
            ['urn', 'string'],
            ['id', 'integer'],
            ['author', $this->yandexFotki->authorValidator],
            ['access', 'string'],
            ['isForAdult', 'boolean'],
            ['isHideOriginal', 'boolean'],
            ['isDisableComments', 'boolean'],
            ['images', 'each', 'rule' => [$this->yandexFotki->imageValidator]],
            ['point', $this->yandexFotki->pointValidator],
            ['addressBinding', $this->yandexFotki->addressBindingValidator],
            ['publishedAt', 'string'],
            ['updatedAt', 'string'],
            ['editedAt', 'string'],
            ['linkSelf', 'string'],
            ['linkEdit', 'string'],
            ['linkAlternate', 'string'],
            ['linkEditMedia', 'string'],
            ['linkAlbum', 'string'],
        ];
    }

    /**
     * @param array $data
     *
     * @return $this
     */
    public function loadWithData($data)
    {
        $author = $this->yandexFotki->createAuthorModel();
        $author->loadWithData(ArrayHelper::getValue($data, 'authors.0'));

        $point = $this->yandexFotki->createPointModel();
        $point->loadWithData(ArrayHelper::getValue($data, 'geo'));

        $addressBinding = $this->yandexFotki->createAddressBindingModel();
        $addressBinding->loadWithData(ArrayHelper::getValue($data, 'authors.0'));

        $images = [];
        foreach (ArrayHelper::getValue($data, 'img', []) as $size => $imageData) {
            $imageData['size'] = $size;

            $image = $this->yandexFotki->createImageModel();
            $image->loadWithData($imageData);

            $images[$size] = $image;
        }

        $this->load([
            $this->formName() => [
                'urn'               => ArrayHelper::getValue($data, 'id'),
                'id'                => ArrayHelper::getValue($data, $this->getIdParser()),
                'author'            => $author,
                'access'            => ArrayHelper::getValue($data, 'access'),
                'isForAdult'        => ArrayHelper::getValue($data, 'xxx', false),
                'isHideOriginal'    => ArrayHelper::getValue($data, 'hide_original', false),
                'isDisableComments' => ArrayHelper::getValue($data, 'disable_comments', false),
                'images'            => $images,
                'point'             => $point,
                'addressBinding'    => $addressBinding,
                'publishedAt'       => ArrayHelper::getValue($data, $this->getDateParser('published')),
                'updatedAt'         => ArrayHelper::getValue($data, $this->getDateParser('updated')),
                'editedAt'          => ArrayHelper::getValue($data, $this->getDateParser('edited')),
                'linkSelf'          => ArrayHelper::getValue($data, 'links.self'),
                'linkEdit'          => ArrayHelper::getValue($data, 'links.edit'),
                'linkAlternate'     => ArrayHelper::getValue($data, 'links.alternate'),
                'linkEditMedia'     => ArrayHelper::getValue($data, 'links.edit-media'),
                'linkAlbum'         => ArrayHelper::getValue($data, 'links.album'),

            ],
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

    /**
     * @param string $key
     *
     * @return \Closure
     */
    public function getDateParser($key)
    {
        /**
         * @param $array
         * @param $defaultValue
         *
         * @return mixed
         */
        return function ($array, $defaultValue) use ($key) {
            return \Yii::$app->formatter->asDate(ArrayHelper::getValue($array, $key)) ?: $defaultValue;
        };
    }
}