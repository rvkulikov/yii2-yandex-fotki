<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 9:03
 */

namespace romkaChev\yandexFotki\interfaces\models;

use DateTime;
use romkaChev\yandexFotki\interfaces\LoadableWithData;
use romkaChev\yandexFotki\interfaces\models\options\AbstractGetAlbumPhotosOptions;
use romkaChev\yandexFotki\traits\parsers\AuthorParser;
use romkaChev\yandexFotki\traits\parsers\DateParser;
use yii\helpers\ArrayHelper;

/**
 * Class AbstractAlbum
 *
 * @package romkaChev\yandexFotki\interfaces\models
 */
abstract class AbstractAlbum extends AbstractModel implements LoadableWithData
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