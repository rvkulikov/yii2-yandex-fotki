<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 9:02
 */

namespace romkaChev\yandexFotki\models;

use DateTime;
use romkaChev\yandexFotki\interfaces\LoadableWithData;
use romkaChev\yandexFotki\interfaces\models\IAccess;
use romkaChev\yandexFotki\interfaces\models\IImageSize;
use romkaChev\yandexFotki\traits\parsers\AddressBindingParser;
use romkaChev\yandexFotki\traits\parsers\AuthorParser;
use romkaChev\yandexFotki\traits\parsers\DateParser;
use romkaChev\yandexFotki\traits\parsers\ImagesParser;
use romkaChev\yandexFotki\traits\parsers\PointParser;
use romkaChev\yandexFotki\traits\parsers\TagsParser;
use yii\helpers\ArrayHelper;

/**
 * Class Photo
 *
 * @package romkaChev\yandexFotki\models
 */
class Photo extends AbstractModel implements IImageSize, IAccess, LoadableWithData
{
    use AuthorParser, ImagesParser, PointParser, AddressBindingParser, DateParser, TagsParser;

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
    public $access;
    /** @var bool */
    public $isForAdult;
    /** @var bool */
    public $hideOriginal;
    /** @var bool */
    public $disableComments;
    /** @var Image[] */
    public $images;
    /** @var Point */
    public $point;
    /** @var AddressBinding */
    public $addressBinding;
    /** @var DateTime */
    public $publishedAt;
    /** @var DateTime */
    public $updatedAt;
    /** @var DateTime */
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
    /** @var int */
    public $albumId;
    /** @var Album */
    protected $album;
    /** @var Tag[] */
    protected $tags;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $factory = $this->getYandexFotki()->getFactory();

        return [
            ['urn', 'string'],
            ['id', 'integer'],
            ['author', $factory->getAuthorValidator()],
            ['title', 'string'],
            ['summary', 'string'],
            ['access', 'string'],
            ['isForAdult', 'boolean'],
            ['hideOriginal', 'boolean'],
            ['disableComments', 'boolean'],
            ['images', 'each', 'rule' => [$factory->getImageValidator()]],
            ['point', $factory->getPointValidator()],
            ['addressBinding', $factory->getAddressBindingValidator()],
            ['publishedAt', 'string'],
            ['updatedAt', 'string'],
            ['editedAt', 'url'],
            ['linkSelf', 'url'],
            ['linkEdit', 'url'],
            ['linkAlternate', 'url'],
            ['linkEditMedia', 'url'],
            ['linkAlbum', 'url'],
            ['albumId', 'integer'],
            ['album', $factory->getAlbumValidator()],
            ['tags', 'each', 'rule' => [$factory->getTagValidator()]]
        ];
    }

    /**
     * @inheritdoc
     */
    public function loadWithData($data, $fast = false)
    {
        $factory    = $this->getYandexFotki()->getFactory();
        $attributes = [
            'urn'             => ArrayHelper::getValue($data, 'id'),
            'id'              => ArrayHelper::getValue($data, $this->getIdParser()),
            'author'          => ArrayHelper::getValue($data, $this->getAuthorParser('authors.0', $factory->getAuthorModel(), $fast)),
            'title'           => ArrayHelper::getValue($data, 'title'),
            'summary'         => ArrayHelper::getValue($data, 'summary'),
            'access'          => ArrayHelper::getValue($data, 'access'),
            'isForAdult'      => ArrayHelper::getValue($data, 'xxx'),
            'hideOriginal'    => ArrayHelper::getValue($data, 'hide_original'),
            'disableComments' => ArrayHelper::getValue($data, 'disable_comments'),
            'images'          => ArrayHelper::getValue($data, $this->getImagesParser('img', $factory->getImageModel(), $fast)),
            'point'           => ArrayHelper::getValue($data, $this->getPointParser('geo', $factory->getPointModel(), $fast)),
            'addressBinding'  => ArrayHelper::getValue($data, $this->getAddressBindingParser('addressBinding.0', $factory->getAddressBindingModel(), $fast)),
            'publishedAt'     => ArrayHelper::getValue($data, $this->getDateParser('published', $this->getYandexFotki()->getFormatter())),
            'updatedAt'       => ArrayHelper::getValue($data, $this->getDateParser('updated', $this->getYandexFotki()->getFormatter())),
            'editedAt'        => ArrayHelper::getValue($data, $this->getDateParser('edited', $this->getYandexFotki()->getFormatter())),
            'linkSelf'        => ArrayHelper::getValue($data, 'links.self'),
            'linkEdit'        => ArrayHelper::getValue($data, 'links.edit'),
            'linkAlternate'   => ArrayHelper::getValue($data, 'links.alternate'),
            'linkEditMedia'   => ArrayHelper::getValue($data, 'links.editMedia'),
            'linkAlbum'       => ArrayHelper::getValue($data, 'links.album'),
            'albumId'         => ArrayHelper::getValue($data, $this->getAlbumIdParser()),
            'tags'            => ArrayHelper::getValue($data, $this->getTagsParser('tags', $factory->getTagModel(), $fast)),
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
    public function getAlbumIdParser()
    {
        /**
         * @param $array
         * @param $defaultValue
         *
         * @return mixed
         */
        return function ($array, $defaultValue) {
            $value = ArrayHelper::getValue($array, 'links.album');
            preg_match('/.*\/users\/([^\/]*)\/album\/(?<albumId>[^\/]*)/', $value, $matches);

            return intval(ArrayHelper::getValue($matches, 'albumId')) ?: $defaultValue;
        };
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
     * @return Album
     */
    public function getAlbum()
    {
        if ($this->album) {
            return $this->album;
        }

        if (!$this->albumId) {
            return null;
        }

        $component   = $this->getYandexFotki()->getAlbums();
        $this->album = $component->get($this->albumId);

        return $this->album;
    }

    /**
     * @param Album $album
     */
    public function setAlbum($album)
    {
        $this->album = $album;
    }
    
    /**
     * @return Tag[]
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param Tag[] $tags
     */
    public function setTags($tags)
    {
        $this->tags = $tags;
    }
}