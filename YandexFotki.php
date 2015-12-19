<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 11:12
 */

namespace romkaChev\yandexFotki;


use InvalidArgumentException;
use romkaChev\yandexFotki\components\AlbumComponent;
use romkaChev\yandexFotki\components\PhotoComponent;
use romkaChev\yandexFotki\components\TagComponent;
use romkaChev\yandexFotki\interfaces\components\IAlbumComponent;
use romkaChev\yandexFotki\interfaces\components\IPhotoComponent;
use romkaChev\yandexFotki\interfaces\components\ITagComponent;
use romkaChev\yandexFotki\interfaces\IYandexFotki;
use romkaChev\yandexFotki\models\AddressBinding;
use romkaChev\yandexFotki\models\Album;
use romkaChev\yandexFotki\models\Author;
use romkaChev\yandexFotki\models\Photo;
use romkaChev\yandexFotki\models\Tag;
use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\caching\Cache;
use yii\caching\DummyCache;
use yii\helpers\ArrayHelper;
use yii\httpclient\Client;

/**
 * Class Module
 *
 * @package romkaChev\yandexFotki
 *
 * @property Client         httpClient
 * @property Cache          cache
 * @property AlbumComponent albums
 * @property PhotoComponent photos
 * @property TagComponent   tags
 */
class YandexFotki extends Component implements IYandexFotki
{
    public $login      = null;
    public $oauthToken = null;

    public $addressBindingModel;
    public $albumModel;
    public $authorModel;
    public $photoModel;
    public $tagModel;

    /**
     * @var Client
     */
    private $_httpClient;
    /**
     * @var Cache
     */
    private $_cache;
    /**
     * @var IAlbumComponent
     */
    private $_albums;
    /**
     * @var IPhotoComponent
     */
    private $_photos;
    /**
     * @var ITagComponent
     */
    private $_tags;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $httpClient                 = $this->httpClient;
        $httpClient->baseUrl        = "http://api-fotki.yandex.ru/api/users/{$this->login}";
        $httpClient->requestConfig  = [
            'headers' => [
                'Content-Type'  => 'application/json; charset=utf-8; type=entry',
                'Authorization' => "OAuth {$this->oauthToken}",
            ],
        ];
        $httpClient->responseConfig = [
            'format' => $httpClient::FORMAT_JSON,
        ];
    }

    /**
     * @inheritdoc
     */
    public function setHttpClient($value)
    {

        if (!$value instanceof Client) {
            $value = Yii::createObject($value);
        }

        if (!$value instanceof Client) {
            $instance = Client::className();
            $type     = gettype($value);
            throw new InvalidArgumentException("Value must be an instance of '{$instance}', '{$type}' given.");
        }

        $this->_httpClient = $value;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getHttpClient()
    {
        if (!$this->_httpClient) {
            throw new InvalidConfigException('HttpClient property was not specified');
        }

        return $this->_httpClient;
    }

    /**
     * @inheritdoc
     */
    public function setCache($value)
    {
        if (!$value instanceof Cache) {
            $value = Yii::createObject($value);
        }

        if (!$value instanceof Cache) {
            $instance = Cache::className();
            $type     = gettype($value);
            throw new InvalidArgumentException("Value must be an instance of '{$instance}', '{$type}' given.");
        }

        $this->_cache = $value;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getCache()
    {
        if (!$this->_cache) {
            trigger_error('Cache property was not specified', E_WARNING);

            return new DummyCache();
        }

        return $this->_cache;
    }

    /**
     * @inheritdoc
     */
    public function setAlbums($value)
    {
        if (!$value instanceof IAlbumComponent) {
            $value = Yii::createObject($value);
        }

        if (!$value instanceof IAlbumComponent) {
            $instance = IAlbumComponent::CLASS_NAME;
            $type     = gettype($value);
            throw new InvalidArgumentException("Value must be an instance of '{$instance}', '{$type}' given.");
        }

        $this->_albums = $value;

        if ($this->_albums->yandexFotki === null) {
            $this->_albums->yandexFotki = $this;
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getAlbums()
    {
        if (!$this->_albums) {
            throw new InvalidConfigException('Albums property was not specified');
        }

        return $this->_albums;
    }

    /**
     * @inheritdoc
     */
    public function setPhotos($value)
    {
        if (!$value instanceof IPhotoComponent) {
            $value = Yii::createObject($value);
        }

        if (!$value instanceof IPhotoComponent) {
            $instance = IPhotoComponent::CLASS_NAME;
            $type     = gettype($value);
            throw new InvalidArgumentException("Value must be an instance of '{$instance}', '{$type}' given.");
        }

        $this->_photos = $value;

        if ($this->_photos->yandexFotki === null) {
            $this->_photos->yandexFotki = $this;
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getPhotos()
    {
        if (!$this->_photos) {
            throw new InvalidConfigException('Photos property was not specified');
        }

        return $this->_photos;
    }

    /**
     * @inheritdoc
     */
    public function setTags($value)
    {
        if (!$value instanceof ITagComponent) {
            $value = Yii::createObject($value);
        }

        if (!$value instanceof ITagComponent) {
            $instance = ITagComponent::CLASS_NAME;
            $type     = gettype($value);
            throw new InvalidArgumentException("Value must be an instance of '{$instance}', '{$type}' given.");
        }

        $this->_tags = $value;

        if ($this->_tags->yandexFotki === null) {
            $this->_tags->yandexFotki = $this;
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getTags()
    {
        if (!$this->_tags) {
            throw new InvalidConfigException('Tags property was not specified');
        }

        return $this->_tags;
    }

    /**
     * @param array $config
     *
     * @return AddressBinding
     * @throws InvalidConfigException
     */
    public function createAddressBindingModel($config = [])
    {
        $config['class']       = ArrayHelper::getValue($config, 'class', $this->addressBindingModel);
        $config['yandexFotki'] = ArrayHelper::getValue($config, 'yandexFotki', $this);

        return Yii::createObject($config);
    }

    /**
     * @param array $config
     *
     * @return Album
     * @throws InvalidConfigException
     */
    public function createAlbumModel($config = [])
    {
        $config['class']       = ArrayHelper::getValue($config, 'class', $this->albumModel);
        $config['yandexFotki'] = ArrayHelper::getValue($config, 'yandexFotki', $this);

        return Yii::createObject($config);
    }

    /**
     * @param array $config
     *
     * @return Author
     * @throws InvalidConfigException
     */
    public function createAuthorModel($config = [])
    {
        $config['class']       = ArrayHelper::getValue($config, 'class', $this->authorModel);
        $config['yandexFotki'] = ArrayHelper::getValue($config, 'yandexFotki', $this);

        return Yii::createObject($config);
    }

    /**
     * @param array $config
     *
     * @return Photo
     * @throws InvalidConfigException
     */
    public function createPhotoModel($config = [])
    {
        $config['class']       = ArrayHelper::getValue($config, 'class', $this->photoModel);
        $config['yandexFotki'] = ArrayHelper::getValue($config, 'yandexFotki', $this);

        return Yii::createObject($config);
    }

    /**
     * @param array $config
     *
     * @return Tag
     * @throws InvalidConfigException
     */
    public function createTagModel($config = [])
    {
        $config['class']       = ArrayHelper::getValue($config, 'class', $this->tagModel);
        $config['yandexFotki'] = ArrayHelper::getValue($config, 'yandexFotki', $this);

        return Yii::createObject($config);
    }
}