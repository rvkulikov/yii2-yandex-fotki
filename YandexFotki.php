<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 11:12
 */

namespace romkaChev\yandexFotki;


use InvalidArgumentException;
use romkaChev\yandexFotki\formatters\JsonFormatter;
use romkaChev\yandexFotki\interfaces\components\IAlbumComponent;
use romkaChev\yandexFotki\interfaces\components\IPhotoComponent;
use romkaChev\yandexFotki\interfaces\components\ITagComponent;
use romkaChev\yandexFotki\interfaces\IFactory;
use romkaChev\yandexFotki\interfaces\IYandexFotki;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\caching\Cache;
use yii\caching\DummyCache;
use yii\httpclient\Client;

/**
 * Class YandexFotki
 *
 * @package romkaChev\yandexFotki
 */
final class YandexFotki extends Component implements IYandexFotki
{
    /** @var string */
    private $login;
    /** @var string */
    private $oauthToken;

    /** @var IFactory */
    private $factory;
    /** @var Client */
    private $httpClient;
    /** @var Cache */
    private $cache;
    /** @var IAlbumComponent */
    private $albums;
    /** @var IPhotoComponent */
    private $photos;
    /** @var ITagComponent */
    private $tags;

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
                'Accept'        => 'application/json',
                'Authorization' => "OAuth {$this->oauthToken}",
            ],
            'format'  => $httpClient::FORMAT_JSON,
        ];
        $httpClient->responseConfig = [
            'format' => $httpClient::FORMAT_JSON,
        ];
        $httpClient->formatters     = [
            $httpClient::FORMAT_JSON => JsonFormatter::className()
        ];
    }


    /**
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @return string
     */
    public function getOauthToken()
    {
        return $this->oauthToken;
    }

    /**
     * @inheritdoc
     */
    public function getFactory()
    {
        if (!$this->factory) {
            throw new InvalidConfigException("'factory' property was not specified");
        }

        return $this->factory;
    }

    /**
     * @inheritdoc
     */
    public function getHttpClient()
    {
        if (!$this->httpClient) {
            throw new InvalidConfigException('HttpClient property was not specified');
        }

        return $this->httpClient;
    }

    /**
     * @inheritdoc
     */
    public function getCache()
    {
        if (!$this->cache) {
            trigger_error('Cache property was not specified', E_WARNING);

            return new DummyCache();
        }

        return $this->cache;
    }

    /**
     * @inheritdoc
     */
    public function getAlbums()
    {
        if (!$this->albums) {
            throw new InvalidConfigException('Albums property was not specified');
        }

        return $this->albums;
    }

    /**
     * @inheritdoc
     */
    public function getPhotos()
    {
        if (!$this->photos) {
            throw new InvalidConfigException('Photos property was not specified');
        }

        return $this->photos;
    }

    /**
     * @inheritdoc
     */
    public function getTags()
    {
        if (!$this->tags) {
            throw new InvalidConfigException('Tags property was not specified');
        }

        return $this->tags;
    }

    /**
     * @param string $login
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @param string $oauthToken
     */
    public function setOauthToken($oauthToken)
    {
        $this->oauthToken = $oauthToken;
    }

    /**
     * @inheritdoc
     */
    public function setFactory($value)
    {
        if (!$value instanceof IFactory) {
            $value = \Yii::createObject($value);
        }

        if (!$value instanceof IFactory) {
            $instance = '\romkaChev\yandexFotki\interfaces\IFactory'; // todo hardcode
            $type     = get_class($value);
            throw new InvalidArgumentException("Value must be an instance of '{$instance}', '{$type}' given.");
        }

        $this->factory = $value;

        if (!$this->factory->getYandexFotki()) {
            $this->factory->setYandexFotki($this);
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setHttpClient($value)
    {
        if (!$value instanceof Client) {
            $value = \Yii::createObject($value);
        }

        if (!$value instanceof Client) {
            $instance = Client::className();
            $type     = get_class($value);
            throw new InvalidArgumentException("Value must be an instance of '{$instance}', '{$type}' given.");
        }

        $this->httpClient = $value;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setCache($value)
    {
        if (!$value instanceof Cache) {
            $value = \Yii::createObject($value);
        }

        if (!$value instanceof Cache) {
            $instance = Cache::className();
            $type     = get_class($value);
            throw new InvalidArgumentException("Value must be an instance of '{$instance}', '{$type}' given.");
        }

        $this->cache = $value;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setAlbums($value)
    {
        if (!$value instanceof IAlbumComponent) {
            $value = \Yii::createObject($value);
        }

        if (!$value instanceof IAlbumComponent) {
            $instance = '\romkaChev\yandexFotki\interfaces\components\IAlbumComponent'; // todo hardcode
            $type     = get_class($value);
            throw new InvalidArgumentException("Value must be an instance of '{$instance}', '{$type}' given.");
        }

        $this->albums = $value;

        if ($this->albums->yandexFotki === null) {
            $this->albums->yandexFotki = $this;
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setPhotos($value)
    {
        if (!$value instanceof IPhotoComponent) {
            $value = \Yii::createObject($value);
        }

        if (!$value instanceof IPhotoComponent) {
            $instance = '\romkaChev\yandexFotki\interfaces\components\IPhotoComponent'; // todo hardcode
            $type     = get_class($value);
            throw new InvalidArgumentException("Value must be an instance of '{$instance}', '{$type}' given.");
        }

        $this->photos = $value;

        if ($this->photos->yandexFotki === null) {
            $this->photos->yandexFotki = $this;
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setTags($value)
    {
        if (!$value instanceof ITagComponent) {
            $value = \Yii::createObject($value);
        }

        if (!$value instanceof ITagComponent) {
            $instance = '\romkaChev\yandexFotki\interfaces\components\ITagComponent'; // todo hardcode
            $type     = get_class($value);
            throw new InvalidArgumentException("Value must be an instance of '{$instance}', '{$type}' given.");
        }

        $this->tags = $value;

        if ($this->tags->yandexFotki === null) {
            $this->tags->yandexFotki = $this;
        }

        return $this;
    }

}