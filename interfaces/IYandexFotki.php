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
use romkaChev\yandexFotki\interfaces\models\IAddressBinding;
use romkaChev\yandexFotki\interfaces\models\IAlbum;
use romkaChev\yandexFotki\interfaces\models\IAuthor;
use romkaChev\yandexFotki\interfaces\models\IPhoto;
use romkaChev\yandexFotki\interfaces\models\ITag;
use yii\base\InvalidConfigException;
use yii\caching\Cache;
use yii\httpclient\Client;

/**
 * Interface IYandexFotki
 *
 * @package romkaChev\yandexFotki\interfaces
 *
 * @property string          oauthToken
 *
 * @property Client          httpClient
 * @property Cache           cache
 * @property IAlbumComponent albums
 * @property IPhotoComponent photos
 * @property ITagComponent   tags
 */
interface IYandexFotki
{

    const CLASS_NAME = __CLASS__;

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
     * @return Client
     */
    public function getHttpClient();

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
     * @return Cache
     */
    public function getCache();

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
     * @throws InvalidConfigException
     *
     * @return IAlbumComponent
     */
    public function getAlbums();

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
     * @throws InvalidConfigException
     *
     * @return IPhotoComponent
     */
    public function getPhotos();

    /**
     * @param ITagComponent|string|array|callable $value
     *
     * @throws InvalidConfigException
     * @throws InvalidArgumentException
     *
     * @return static
     */
    public function setTags($value);

    /**
     * @throws InvalidConfigException
     *
     * @return ITagComponent
     */
    public function getTags();

    /**
     * @param array $config
     *
     * @return IAddressBinding
     * @throws InvalidConfigException
     */
    public function createAddressBindingModel($config);

    /**
     * @param array $config
     *
     * @return IAlbum
     * @throws InvalidConfigException
     */
    public function createAlbumModel($config);

    /**
     * @param array $config
     *
     * @return IAuthor
     * @throws InvalidConfigException
     */
    public function createAuthorModel($config);

    /**
     * @param array $config
     *
     * @return IPhoto
     * @throws InvalidConfigException
     */
    public function createPhotoModel($config);

    /**
     * @param array $config
     *
     * @return ITag
     * @throws InvalidConfigException
     */
    public function createTagModel($config);
}