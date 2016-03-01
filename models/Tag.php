<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 8:50
 */

namespace romkaChev\yandexFotki\models;

use DateTime;
use romkaChev\yandexFotki\interfaces\LoadableWithData;
use romkaChev\yandexFotki\models\options\GetTagPhotosOptions;
use romkaChev\yandexFotki\traits\parsers\AuthorParser;
use romkaChev\yandexFotki\traits\parsers\DateParser;
use yii\helpers\ArrayHelper;

/**
 * Class Tag
 *
 * @package romkaChev\yandexFotki\models
 */
class Tag extends AbstractModel implements LoadableWithData
{
    use DateParser, AuthorParser;

    /** @var string */
    public $urn;
    /** @var int */
    public $id;
    /** @var string */
    public $title;
    /** @var Author */
    public $author;
    /** @var DateTime */
    public $updatedAt;
    /** @var string */
    public $linkSelf;
    /** @var string */
    public $linkEdit;
    /** @var string */
    public $linkPhotos;
    /** @var string */
    public $linkAlternate;
    /** @var Photo[] */
    protected $photos;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //@formatter:off
            ['id', 'string'],
            ['id', 'required'],

            ['urn', 'string'],
            ['urn', 'default', 'value' => function(){return $this->defaultUrn();}],

            ['title', 'string'],
            ['title', 'default', 'value' => function(){return $this->defaultTitle();}],

            ['author', $this->getYandexFotki()->getFactory()->getAuthorValidator()],
            ['author', 'default', 'value' => function(){return $this->defaultAuthor();}],
            
            ['updatedAt', 'string'],

            ['linkSelf', 'url'],
            ['linkSelf', 'default', 'value' => function(){return $this->defaultLinkSelf();}],

            ['linkEdit', 'url'],
            ['linkEdit', 'default', 'value' => function(){return $this->defaultLinkEdit();}],

            ['linkPhotos', 'url'],
            ['linkPhotos', 'default', 'value' => function(){return $this->defaultLinkPhotos();}],

            ['linkAlternate', 'url'],
            ['linkAlternate', 'default', 'value' => function(){return $this->defaultLinkAlternate();}],
            
            ['photos', 'each', 'rule' => [$this->getYandexFotki()->getFactory()->getPhotoValidator()]]
            //@formatter:on
        ];
    }

    /**
     * @return string
     */
    public function defaultUrn()
    {
        $login = $this->getYandexFotki()->getLogin();

        return "urn:yandex:fotki:{$login}:tag:{$this->id}";
    }

    /**
     * @return string
     */
    public function defaultTitle()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function defaultAuthor()
    {
        $factory     = $this->getYandexFotki()->getFactory();
        $authorModel = $factory->getAuthorModel();

        $authorModel->loadWithData([
            'name' => $this->getYandexFotki()->getLogin()
        ], true);
    }

    /**
     * @return string
     */
    public function defaultAuthors()
    {
        return [['name' => $this->getYandexFotki()->getLogin()]];
    }

    /**
     * @return string
     */
    public function defaultLinkSelf()
    {
        $httpClient = $this->getYandexFotki()->getApiHttpClient();
        $baseUrl    = $httpClient->baseUrl;
        $tag        = urlencode($this->id);

        return "{$baseUrl}/tag/{$tag}/";
    }

    /**
     * @return string
     */
    public function defaultLinkEdit()
    {
        $httpClient = $this->getYandexFotki()->getApiHttpClient();
        $baseUrl    = $httpClient->baseUrl;
        $tag        = urlencode($this->id);

        return "{$baseUrl}/tag/{$tag}/";
    }

    /**
     * @return string
     */
    public function defaultLinkPhotos()
    {
        $httpClient = $this->getYandexFotki()->getApiHttpClient();
        $baseUrl    = $httpClient->baseUrl;
        $tag        = urlencode($this->id);

        return "{$baseUrl}/tag/{$tag}/photos/";
    }

    /**
     * @return string
     */
    public function defaultLinkAlternate()
    {
        $httpClient = $this->getYandexFotki()->getServiceHttpClient();
        $baseUrl    = $httpClient->baseUrl;
        $tag        = urlencode($this->id);

        return "{$baseUrl}/tags/{$tag}/";
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
            'title'         => ArrayHelper::getValue($data, 'title'),
            'author'        => ArrayHelper::getValue($data, $this->getAuthorParser('authors.0', $factory->getAuthorModel(), $fast)),
            'updatedAt'     => ArrayHelper::getValue($data, $this->getDateParser('updated', $this->getYandexFotki()->getFormatter())),
            'linkSelf'      => ArrayHelper::getValue($data, 'links.self'),
            'linkEdit'      => ArrayHelper::getValue($data, 'links.edit'),
            'linkPhotos'    => ArrayHelper::getValue($data, 'links.photos'),
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
    public function getPhotos(GetTagPhotosOptions $options = null)
    {
        if (!$this->photos) {
            $component    = $this->getYandexFotki()->getTags();
            $this->photos = $component->getPhotos($this->id, $options);
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
            preg_match('/^urn:yandex:fotki:([^:]*):tag:(?<id>.*)$/', $value, $matches);

            return ArrayHelper::getValue($matches, 'id') ?: $defaultValue;
        };
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->__toString();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->title;
    }
}