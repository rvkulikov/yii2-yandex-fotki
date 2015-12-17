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

/**
 * Interface IModule
 *
 * @package romkaChev\yandexFotki\interfaces
 *
 * @property string oauthToken
 */
interface IModule
{
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

}