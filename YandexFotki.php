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
use yii\helpers\ArrayHelper;
use yii\httpclient\Client;
use yii\i18n\Formatter;

/**
 * Class YandexFotki
 *
 * @package romkaChev\yandexFotki
 */
final class YandexFotki extends Component implements IYandexFotki
{
    /** @var string */
    private $apiBaseUrl = 'http://api-fotki.yandex.ru/api';
    /** @var string */
    private $serviceBaseUrl = 'http://fotki.yandex.ru';

    /** @var string */
    private $login;
    /** @var string */
    private $oauthToken;

    /** @var string */
    private $pubChannel;
    /** @var string */
    private $appPlatform;
    /** @var string */
    private $appVersion;

    /** @var Formatter */
    private $formatter;
    /** @var IFactory */
    private $factory;
    /** @var Client */
    private $apiHttpClient;
    /** @var Client */
    private $serviceHttpClient;
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

        //<editor-fold desc="Api Http Client">
        $apiHttpClient = $this->getApiHttpClient();

        $apiHttpClient->baseUrl = $apiHttpClient->baseUrl ?: "{$this->apiBaseUrl}/users/{$this->login}";

        $apiHttpClient->requestConfig = array_replace_recursive([
            'headers' => [
                'Accept'        => 'application/json',
                'Authorization' => "OAuth {$this->oauthToken}",
            ],
            'format'  => $apiHttpClient::FORMAT_JSON,
        ], $apiHttpClient->requestConfig);

        $apiHttpClient->responseConfig = array_replace_recursive([
            'format' => $apiHttpClient::FORMAT_JSON,
        ], $apiHttpClient->responseConfig);

        $apiHttpClient->formatters = [
            $apiHttpClient::FORMAT_JSON => JsonFormatter::className()
        ];

        $this->setApiHttpClient($apiHttpClient);
        //</editor-fold>

        //<editor-fold desc="Service Http Client">
        $serviceHttpClient          = $this->getServiceHttpClient();
        $serviceHttpClient->baseUrl = $serviceHttpClient->baseUrl ?: "{$this->serviceBaseUrl}/users/{$this->login}";

        $this->setServiceHttpClient($serviceHttpClient);
        //</editor-fold>
    }

    /**
     * @inheritdoc
     */
    public function getApiBaseUrl()
    {
        return $this->apiBaseUrl;
    }

    /**
     * @inheritdoc
     */
    public function setApiBaseUrl($apiBaseUrl)
    {
        $this->apiBaseUrl = $apiBaseUrl;
    }

    /**
     * @inheritdoc
     */
    public function getServiceBaseUrl()
    {
        return $this->serviceBaseUrl;
    }

    /**
     * @inheritdoc
     */
    public function setServiceBaseUrl($serviceBaseUrl)
    {
        $this->serviceBaseUrl = $serviceBaseUrl;
    }

    /**
     * @inheritdoc
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @inheritdoc
     */
    public function setLogin($login)
    {
        $this->login = $login;
    }

    /**
     * @inheritdoc
     */
    public function getOauthToken()
    {
        return $this->oauthToken;
    }

    /**
     * @inheritdoc
     */
    public function setOauthToken($oauthToken)
    {
        $this->oauthToken = $oauthToken;
    }

    /**
     * @inheritdoc
     */
    public function getPubChannel()
    {
        return $this->pubChannel;
    }

    /**
     * @inheritdoc
     */
    public function setPubChannel($pubChannel)
    {
        $this->pubChannel = $pubChannel;
    }

    /**
     * @inheritdoc
     */
    public function getAppPlatform()
    {
        return $this->appPlatform;
    }

    /**
     * @inheritdoc
     */
    public function setAppPlatform($appPlatform)
    {
        $this->appPlatform = $appPlatform;
    }

    /**
     * @inheritdoc
     */
    public function getAppVersion()
    {
        return $this->appVersion;
    }

    /**
     * @inheritdoc
     */
    public function setAppVersion($appVersion)
    {
        $this->appVersion = $appVersion;
    }

    /**
     * @inheritdoc
     */
    public function getFormatter()
    {
        $this->preProcessConfigurableItem('formatter', Formatter::className());

        return $this->formatter;
    }

    /**
     * @inheritdoc
     */
    public function setFormatter($value)
    {
        $this->formatter = $value;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getFactory()
    {
        $this->preProcessConfigurableItemWithInjection('factory', '\romkaChev\yandexFotki\interfaces\IFactory'); // todo hardcode
        return $this->factory;
    }

    /**
     * @inheritdoc
     */
    public function setFactory($value)
    {
        $this->factory = $value;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getApiHttpClient()
    {
        $this->preProcessConfigurableItem('apiHttpClient', Client::className());

        return $this->apiHttpClient;
    }

    /**
     * @inheritdoc
     */
    public function setApiHttpClient($value)
    {
        $this->apiHttpClient = $value;

        return $this;
    }

    /**
     * @return Client
     */
    public function getServiceHttpClient()
    {
        $this->preProcessConfigurableItem('serviceHttpClient', Client::className());

        return $this->serviceHttpClient;
    }

    /**
     * @inheritdoc
     */
    public function setServiceHttpClient($value)
    {
        $this->serviceHttpClient = $value;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getCache()
    {
        $this->preProcessConfigurableItem('cache', Cache::className());

        return $this->cache;
    }

    /**
     * @inheritdoc
     */
    public function setCache($value)
    {
        $this->cache = $value;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getAlbums()
    {
        $this->preProcessConfigurableItemWithInjection('albums', '\romkaChev\yandexFotki\interfaces\components\IAlbumComponent'); // todo hardcode
        return $this->albums;
    }

    /**
     * @inheritdoc
     */
    public function setAlbums($value)
    {
        $this->albums = $value;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getPhotos()
    {
        $this->preProcessConfigurableItemWithInjection('photos', '\romkaChev\yandexFotki\interfaces\components\IPhotoComponent'); // todo hardcode
        return $this->photos;
    }

    /**
     * @inheritdoc
     */
    public function setPhotos($value)
    {
        $this->photos = $value;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getTags()
    {
        $this->preProcessConfigurableItemWithInjection('tags', '\romkaChev\yandexFotki\interfaces\components\ITagComponent'); // todo hardcode
        return $this->tags;
    }

    /**
     * @inheritdoc
     */
    public function setTags($value)
    {
        $this->tags = $value;

        return $this;
    }

    /**
     * @param string $attribute
     * @param string $instance
     *
     * @throws InvalidConfigException
     */
    protected function preProcessConfigurableItem($attribute, $instance)
    {
        if (!$this->{$attribute} instanceof $instance) {
            $this->{$attribute} = \Yii::createObject($this->{$attribute});

            if (!$this->{$attribute} instanceof $instance) {
                $type = get_class($this->{$attribute});
                throw new InvalidArgumentException("'{$attribute}' must be an instance of '{$instance}', '{$type}' given.");
            }
        }
    }

    /**
     * @param string $attribute
     * @param string $instance
     *
     * @throws InvalidConfigException
     */
    protected function preProcessConfigurableItemWithInjection($attribute, $instance)
    {
        if (!$this->{$attribute} instanceof $instance) {
            $this->{$attribute}                = is_string($this->{$attribute}) ? ['class' => $this->{$attribute}] : $this->{$attribute};
            $this->{$attribute}['yandexFotki'] = ArrayHelper::getValue($this->{$attribute}, 'yandexFotki', $this);

            $this->{$attribute} = \Yii::createObject($this->{$attribute});

            if (!$this->{$attribute} instanceof $instance) {
                $type = get_class($this->{$attribute});
                throw new InvalidArgumentException("'{$attribute}' must be an instance of '{$instance}', '{$type}' given.");
            }
        }
    }
}