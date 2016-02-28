<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 8:44
 */

namespace romkaChev\yandexFotki\interfaces;

use InvalidArgumentException;
use romkaChev\yandexFotki\interfaces\components\IAlbumComponent;
use romkaChev\yandexFotki\interfaces\components\IPhotoComponent;
use romkaChev\yandexFotki\interfaces\components\ITagComponent;
use yii\base\InvalidConfigException;
use yii\caching\Cache;
use yii\httpclient\Client;
use yii\i18n\Formatter;

/**
 * Interface IYandexFotki
 *
 * @package romkaChev\yandexFotki\interfaces
 */
interface IYandexFotki
{
    /**
     * @return string
     */
    public function getApiBaseUrl();

    /**
     * @return string
     */
    public function getServiceBaseUrl();

    /**
     * @return string
     */
    public function getLogin();

    /**
     * @return string
     */
    public function getOauthToken();

    /**
     * @return string
     */
    public function getPubChannel();

    /**
     * @return string
     */
    public function getAppPlatform();

    /**
     * @return string
     */
    public function getAppVersion();

    /**
     * @return Formatter
     */
    public function getFormatter();

    /**
     * @return IFactory
     */
    public function getFactory();

    /**
     * @return Client
     */
    public function getApiHttpClient();

    /**
     * @return Client
     */
    public function getServiceHttpClient();

    /**
     * @return Cache
     */
    public function getCache();

    /**
     * @throws InvalidConfigException
     *
     * @return IAlbumComponent
     */
    public function getAlbums();

    /**
     * @throws InvalidConfigException
     *
     * @return IPhotoComponent
     */
    public function getPhotos();

    /**
     * @throws InvalidConfigException
     *
     * @return ITagComponent
     */
    public function getTags();

    /**
     * @param string $apiBaseUrl
     */
    public function setApiBaseUrl($apiBaseUrl);

    /**
     * @param string $serviceBaseUrl
     */
    public function setServiceBaseUrl($serviceBaseUrl);

    /**
     * @param string $login
     */
    public function setLogin($login);

    /**
     * @param string $oauthToken
     */
    public function setOauthToken($oauthToken);

    /**
     * @param string $pubChannel
     */
    public function setPubChannel($pubChannel);

    /**
     * @param string $appPlatform
     */
    public function setAppPlatform($appPlatform);

    /**
     * @param string $appVersion
     */
    public function setAppVersion($appVersion);

    /**
     * @param Formatter|string|array|callable $value
     *
     * @throws InvalidConfigException
     * @throws InvalidArgumentException
     *
     * @return static
     */
    public function setFormatter($value);

    /**
     * @param IFactory|string|array|callable $value
     *
     * @throws InvalidConfigException
     * @throws InvalidArgumentException
     *
     * @return static
     */
    public function setFactory($value);

    /**
     * @param Client|string|array|callable $value
     *
     * @throws InvalidConfigException
     * @throws InvalidArgumentException
     *
     * @return static
     */
    public function setApiHttpClient($value);

    /**
     * @param Client|string|array|callable $value
     *
     * @throws InvalidConfigException
     * @throws InvalidArgumentException
     *
     * @return static
     */
    public function setServiceHttpClient($value);

    /**
     * @param Cache|string|array|callable $value
     *
     * @throws InvalidConfigException
     * @throws InvalidArgumentException
     *
     * @return static
     */
    public function setCache($value);

    /**
     * @param IAlbumComponent|string|array|callable $value
     *
     * @throws InvalidConfigException
     * @throws InvalidArgumentException
     *
     * @return static
     */
    public function setAlbums($value);

    /**
     * @param IPhotoComponent|string|array|callable $value
     *
     * @throws InvalidConfigException
     * @throws InvalidArgumentException
     *
     * @return static
     */
    public function setPhotos($value);

    /**
     * @param ITagComponent|string|array|callable $value
     *
     * @throws InvalidConfigException
     * @throws InvalidArgumentException
     *
     * @return static
     */
    public function setTags($value);

}