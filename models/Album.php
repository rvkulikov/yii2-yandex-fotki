<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 9:03
 */

namespace romkaChev\yandexFotki\models;

use DateTime;
use romkaChev\yandexFotki\interfaces\LoadableWithData;
use romkaChev\yandexFotki\models\options\GetAlbumPhotosOptions;
use romkaChev\yandexFotki\traits\parsers\AuthorParser;
use romkaChev\yandexFotki\traits\parsers\DateParser;
use yii\helpers\ArrayHelper;

/**
 * Class AbstractAlbum
 *
 * @package romkaChev\yandexFotki\interfaces\models
 */
class Album extends AbstractModel implements LoadableWithData
{
    use AuthorParser, DateParser;

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
    /** @var bool */
    public $isProtected;
    /** todo this */
    public $cover;
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
    public $linkPhotos;
    /** @var string */
    public $linkCover;
    /** @var string */
    public $linkYmapsml;
    /** @var string */
    public $linkAlternate;
    /** @var int */
    public $parentId;
    /** @var Photo[] */
    protected $photos;
    /** @var Album */
    protected $parent;
    /** @var Album[] */
    protected $children;

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
            ['isProtected', 'boolean'],
            ['publishedAt', 'string'],
            ['updatedAt', 'string'],
            ['editedAt', 'string'],
            ['linkSelf', 'url'],
            ['linkEdit', 'url'],
            ['linkPhotos', 'url'],
            ['linkCover', 'url'],
            ['linkYmapsml', 'url'],
            ['linkAlternate', 'url'],
            ['photos', 'each', 'rule' => [$factory->getPhotoValidator()]],
            ['parentId', 'integer'],
            ['parent', $factory->getAlbumValidator()],
            ['children', 'each', 'rule' => [$factory->getAlbumValidator()]],
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
            'isProtected'   => ArrayHelper::getValue($data, 'isProtected'),
            'publishedAt'   => ArrayHelper::getValue($data, $this->getDateParser('published', $this->getYandexFotki()->getFormatter())),
            'updatedAt'     => ArrayHelper::getValue($data, $this->getDateParser('updated', $this->getYandexFotki()->getFormatter())),
            'editedAt'      => ArrayHelper::getValue($data, $this->getDateParser('edited', $this->getYandexFotki()->getFormatter())),
            'linkSelf'      => ArrayHelper::getValue($data, 'links.self'),
            'linkEdit'      => ArrayHelper::getValue($data, 'links.edit'),
            'linkPhotos'    => ArrayHelper::getValue($data, 'links.photos'),
            'linkCover'     => ArrayHelper::getValue($data, 'links.cover'),
            'linkYmapsml'   => ArrayHelper::getValue($data, 'links.ymapsml'),
            'linkAlternate' => ArrayHelper::getValue($data, 'links.alternate'),
            'parentId'      => ArrayHelper::getValue($data, $this->getAlbumIdParser())
        ];

        if ($fast) {
            \Yii::configure($this, $attributes);
        } else {
            $this->load([$this->formName() => $attributes]);
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getPhotos(GetAlbumPhotosOptions $options = null)
    {
        if (!$this->photos) {
            $component    = $this->getYandexFotki()->getAlbums();
            $this->photos = $component->getPhotos($this->id, $options);
        }

        return $this->photos;
    }

    /**
     * @return null|Album
     */
    public function getParent()
    {
        if ($this->parent) {
            return $this->parent;
        }

        if (!$this->parentId) {
            return null;
        }

        $component    = $this->getYandexFotki()->getAlbums();
        $this->parent = $component->get($this->parentId);

        return $this->parent;
    }

    /**
     * @param Album $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return Album[]
     */
    public function getChildren()
    {
        if (!$this->children) {
            $component = $this->getYandexFotki()->getAlbums();
            $children  = $component->tree($this->id);
            foreach ($children as $child) {
                $child->setParent($this);
            }
            $this->children = $children;
        }

        return $this->children;
    }

    /**
     * @param Album[] $children
     */
    public function setChildren($children)
    {
        foreach ($children as $child) {
            $child->setParent($this);
        }
        
        $this->children = $children;
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
            preg_match('/^urn:yandex:fotki:([^:]*):album:(?<id>\d+)$/', $value, $matches);

            return intval(ArrayHelper::getValue($matches, 'id')) ?: $defaultValue;
        };
    }
}