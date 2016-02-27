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

/**
 * Interface IYandexFotki
 *
 * @package romkaChev\yandexFotki\interfaces
 */
interface IYandexFotki
{
    /**
     * @return IFactory
     */
    public function getFactory();

    /**
     * @return string
     */
    public function getLogin();

    /**
     * @return string
     */
    public function getOauthToken();

    /**
     * @return Client
     */
    public function getHttpClient();

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
     * @param IFactory|string|array|callable $value
     *
     * @throws InvalidConfigException
     * @throws InvalidArgumentException
     *
     * @return static
     */
    public function setFactory($value);

    /**
     * @param string $login
     */
    public function setLogin($login);

    /**
     * @param string $oauthToken
     */
    public function setOauthToken($oauthToken);

    /**
     * @param Client|string|array|callable $value
     *
     * @throws InvalidConfigException
     * @throws InvalidArgumentException
     *
     * @return static
     */
    public function setHttpClient($value);

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