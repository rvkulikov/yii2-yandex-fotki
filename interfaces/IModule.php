<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 8:44
 */

namespace romkaChev\yandexFotki\interfaces;

use romkaChev\yandexFotki\interfaces\components\IAlbumComponent;
use romkaChev\yandexFotki\interfaces\components\IPhotoComponent;
use romkaChev\yandexFotki\interfaces\components\ITagComponent;
use yii\caching\Cache;

/**
 * Interface IModule
 *
 * @package romkaChev\yandexFotki\interfaces
 *
 * @property IAlbumComponent albums
 * @property IPhotoComponent photos
 * @property ITagComponent   tags
 *
 * @property string          oauthToken
 * @property Cache           cache
 */
interface IModule
{
    /**
     * @param Cache|string|array|callable $value
     *
     * @return mixed
     */
    public function setCache($value);

    /**
     * @return Cache
     */
    public function getCache();
}