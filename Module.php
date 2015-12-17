<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 11:12
 */

namespace romkaChev\yandexFotki;


use InvalidArgumentException;
use romkaChev\yandexFotki\interfaces\components\IAlbumComponent;
use romkaChev\yandexFotki\interfaces\components\IPhotoComponent;
use romkaChev\yandexFotki\interfaces\components\ITagComponent;
use romkaChev\yandexFotki\interfaces\IModule;
use Yii;
use yii\base\InvalidConfigException;
use yii\caching\Cache;
use yii\caching\DummyCache;

/**
 * Class Module
 *
 * @package romkaChev\yandexFotki
 *
 * @property Cache           cache
 * @property IAlbumComponent albums
 * @property IPhotoComponent photos
 * @property ITagComponent   tags
 */
class Module extends \yii\base\Module implements IModule
{

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
     * @param array|callable|string|Cache $value
     *
     * @return $this
     * @throws InvalidConfigException
     * @throws InvalidArgumentException
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
     * @return Cache
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
     * @param array|callable|IAlbumComponent|string $value
     *
     * @return $this
     * @throws InvalidConfigException
     * @throws InvalidArgumentException
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

        return $this;
    }

    /**
     * @return IAlbumComponent
     * @throws InvalidConfigException
     */
    public function getAlbums()
    {
        if (!$this->_albums) {
            throw new InvalidConfigException('Albums property was not specified');
        }

        return $this->_albums;
    }

    /**
     * @param array|callable|IPhotoComponent|string $value
     *
     * @return $this
     * @throws InvalidConfigException
     * @throws InvalidArgumentException
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

        return $this;
    }

    /**
     * @return IAlbumComponent
     * @throws InvalidConfigException
     */
    public function getPhotos()
    {
        if (!$this->_photos) {
            throw new InvalidConfigException('Photos property was not specified');
        }

        return $this->_photos;
    }

    /**
     * @param array|callable|ITagComponent|string $value
     *
     * @return $this
     * @throws InvalidConfigException
     * @throws InvalidArgumentException
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

        return $this;
    }

    /**
     * @return IPhotoComponent
     * @throws InvalidConfigException
     */
    public function getTags()
    {
        if (!$this->_tags) {
            throw new InvalidConfigException('Tags property was not specified');
        }

        return $this->_photos;
    }
}