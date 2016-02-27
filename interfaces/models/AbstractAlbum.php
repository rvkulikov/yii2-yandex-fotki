<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 9:03
 */

namespace romkaChev\yandexFotki\interfaces\models;

use romkaChev\yandexFotki\interfaces\models\options\AbstractGetAlbumPhotosOptions;
use romkaChev\yandexFotki\traits\parsers\AuthorParser;
use romkaChev\yandexFotki\traits\parsers\DateParser;
use yii\helpers\ArrayHelper;

/**
 * Class AbstractAlbum
 *
 * @package romkaChev\yandexFotki\interfaces\models
 */
abstract class AbstractAlbum extends AbstractModel
{
    use AuthorParser, DateParser;

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
    /** @var bool */
    public $isProtected;
    /** todo this */
    public $cover;
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
    public $linkPhotos;
    /** @var string */
    public $linkCover;
    /** @var string */
    public $linkYmapsml;
    /** @var string */
    public $linkAlternate;
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
            'isProtected'   => ArrayHelper::getValue($data, 'isProtected', false),
            'publishedAt'   => ArrayHelper::getValue($data, $this->getDateParser('published')),
            'updatedAt'     => ArrayHelper::getValue($data, $this->getDateParser('updated')),
            'editedAt'      => ArrayHelper::getValue($data, $this->getDateParser('edited')),
            'linkSelf'      => ArrayHelper::getValue($data, 'links.self'),
            'linkEdit'      => ArrayHelper::getValue($data, 'links.edit'),
            'linkPhotos'    => ArrayHelper::getValue($data, 'links.photos'),
            'linkCover'     => ArrayHelper::getValue($data, 'links.cover'),
            'linkYmapsml'   => ArrayHelper::getValue($data, 'links.ymapsml'),
            'linkAlternate' => ArrayHelper::getValue($data, 'links.alternate'),
        ]);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getPhotos(AbstractGetAlbumPhotosOptions $options = null)
    {
        if (!$this->photos) {
            $albumComponent = $this->getYandexFotki()->getAlbums();
            $this->photos   = $albumComponent->getPhotos($this->id, $options);
        }

        return $this->photos;
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