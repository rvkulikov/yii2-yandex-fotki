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
use romkaChev\yandexFotki\interfaces\models\IAlbumPhotosCollection;
use romkaChev\yandexFotki\interfaces\models\IAuthor;
use romkaChev\yandexFotki\interfaces\models\IImage;
use romkaChev\yandexFotki\interfaces\models\IPhoto;
use romkaChev\yandexFotki\interfaces\models\IPoint;
use romkaChev\yandexFotki\interfaces\models\ITag;
use yii\base\InvalidConfigException;
use yii\caching\Cache;
use yii\httpclient\Client;

/**
 * Interface IYandexFotki
 *
 * @package romkaChev\yandexFotki\interfaces
 *
 * @property string                 $oauthToken
 *
 * @property Client                 $httpClient
 * @property Cache                  $cache
 * @property IAlbumComponent        $albums
 * @property IPhotoComponent        $photos
 * @property ITagComponent          $tags
 *
 * @property IAddressBinding        $addressBindingModel
 * @property IAlbum                 $albumModel
 * @property IAlbumPhotosCollection $albumPhotosCollectionModel
 * @property IAuthor                $authorModel
 * @property IPhoto                 $photoModel
 * @property ITag                   $tagModel
 * @property IPoint                 $pointModel
 * @property IImage                 $imageModel
 *
 * @property string|array           $addressBindingValidator
 * @property string|array           $authorValidator
 * @property string|array           $pointValidator
 * @property string|array           $photoValidator
 * @property string|array           $imageValidator
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



    //region models

    /**
     * @return IAddressBinding
     * @throws InvalidConfigException
     */
    public function getAddressBindingModel();

    /**
     * @return IAlbum
     * @throws InvalidConfigException
     */
    public function getAlbumModel();

    /**
     * @return IAuthor
     * @throws InvalidConfigException
     */
    public function getAuthorModel();

    /**
     * @return IPhoto
     * @throws InvalidConfigException
     */
    public function getPhotoModel();

    /**
     * @return ITag
     * @throws InvalidConfigException
     */
    public function getTagModel();

    /**
     * @return IPoint
     * @throws InvalidConfigException
     */
    public function getPointModel();

    /**
     * @return IImage
     * @throws InvalidConfigException
     */
    public function getImageModel();


    /**
     * @param mixed $addressBindingModel
     */
    public function setAddressBindingModel($addressBindingModel);

    /**
     * @param mixed $albumModel
     */
    public function setAlbumModel($albumModel);

    /**
     * @param mixed $albumPhotosCollectionModel
     */
    public function setAlbumPhotosCollectionModel($albumPhotosCollectionModel);

    /**
     * @param mixed $authorModel
     */
    public function setAuthorModel($authorModel);

    /**
     * @param mixed $photoModel
     */
    public function setPhotoModel($photoModel);

    /**
     * @param mixed $tagModel
     */
    public function setTagModel($tagModel);

    /**
     * @param mixed $pointModel
     */
    public function setPointModel($pointModel);

    /**
     * @param mixed $imageModel
     */
    public function setImageModel($imageModel);

    //endregion


    public function setAddressBindingValidator($value);

    public function getAddressBindingValidator();

    public function setAuthorValidator($value);

    public function getAuthorValidator();

    public function setPointValidator($value);

    public function getPointValidator();

    public function setImageValidator($value);

    public function getImageValidator();
}