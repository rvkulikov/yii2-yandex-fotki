<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 27.02.2016
 * Time: 18:38
 */

namespace romkaChev\yandexFotki\interfaces;


use romkaChev\yandexFotki\models\AddressBinding;
use romkaChev\yandexFotki\models\Album;
use romkaChev\yandexFotki\models\AlbumPhotosCollection;
use romkaChev\yandexFotki\models\AlbumsCollection;
use romkaChev\yandexFotki\models\Author;
use romkaChev\yandexFotki\models\Image;
use romkaChev\yandexFotki\models\options\album\CreateAlbumOptions;
use romkaChev\yandexFotki\models\options\album\GetAlbumPhotosOptions;
use romkaChev\yandexFotki\models\options\photo\CreatePhotoOptions;
use romkaChev\yandexFotki\models\options\tag\GetTagPhotosOptions;
use romkaChev\yandexFotki\models\Photo;
use romkaChev\yandexFotki\models\Point;
use romkaChev\yandexFotki\models\Tag;
use romkaChev\yandexFotki\models\TagPhotosCollection;
use yii\base\InvalidConfigException;
use yii\validators\Validator;

/**
 * Interface IFactory
 *
 * @package romkaChev\yandexFotki\interfaces
 */
interface IFactory extends IYandexFotkiAccess
{
    //<editor-fold desc="Models">

    /**
     * @return AddressBinding
     * @throws InvalidConfigException
     */
    public function getAddressBindingModel();

    /**
     * @param mixed $addressBindingModel
     *
     * @return static
     */
    public function setAddressBindingModel($addressBindingModel);

    /**
     * @return Album
     * @throws InvalidConfigException
     */
    public function getAlbumModel();

    /**
     * @param mixed $albumModel
     *
     * @return static
     */
    public function setAlbumModel($albumModel);

    /**
     * @return AlbumsCollection
     * @throws InvalidConfigException
     */
    public function getAlbumsCollectionModel();

    /**
     * @param AlbumsCollection $albumsCollectionModel
     *
     * @return static
     */
    public function setAlbumsCollectionModel($albumsCollectionModel);

    /**
     * @return AlbumPhotosCollection
     * @throws InvalidConfigException
     */
    public function getAlbumPhotosCollectionModel();

    /**
     * @param mixed $albumPhotosCollectionModel
     *
     * @return static
     */
    public function setAlbumPhotosCollectionModel($albumPhotosCollectionModel);

    /**
     * @return Author
     * @throws InvalidConfigException
     */
    public function getAuthorModel();

    /**
     * @param mixed $authorModel
     *
     * @return static
     */
    public function setAuthorModel($authorModel);

    /**
     * @return Photo
     * @throws InvalidConfigException
     */
    public function getPhotoModel();

    /**
     * @param mixed $photoModel
     *
     * @return static
     */
    public function setPhotoModel($photoModel);

    /**
     * @return Tag
     * @throws InvalidConfigException
     */
    public function getTagModel();

    /**
     * @param mixed $tagModel
     *
     * @return static
     */
    public function setTagModel($tagModel);

    /**
     * @return TagPhotosCollection
     */
    public function getTagPhotosCollectionModel();

    /**
     * @param TagPhotosCollection $tagPhotosCollectionModel
     *
     * @return static
     */
    public function setTagPhotosCollectionModel($tagPhotosCollectionModel);

    /**
     * @return Point
     * @throws InvalidConfigException
     */
    public function getPointModel();

    /**
     * @param mixed $pointModel
     *
     * @return static
     */
    public function setPointModel($pointModel);

    /**
     * @return Image
     * @throws InvalidConfigException
     */
    public function getImageModel();

    /**
     * @param mixed $imageModel
     *
     * @return static
     */
    public function setImageModel($imageModel);

    //</editor-fold>

    //<editor-fold desc="Options">

    /**
     * @return CreateAlbumOptions
     * @throws InvalidConfigException
     */
    public function getCreateAlbumOptions();

    /**
     * @param mixed $createAlbumOptions
     *
     * @return static
     */
    public function setCreateAlbumOptions($createAlbumOptions);

    /**
     * @return GetAlbumPhotosOptions
     * @throws InvalidConfigException
     */
    public function getGetAlbumPhotosOptions();

    /**
     * @param mixed $getAlbumPhotosOptions
     *
     * @return static
     */
    public function setGetAlbumPhotosOptions($getAlbumPhotosOptions);

    /**
     * @return CreatePhotoOptions
     * @throws InvalidConfigException
     */
    public function getCreatePhotoOptions();

    /**
     * @param mixed $createPhotoOptions
     *
     * @return static
     */
    public function setCreatePhotoOptions($createPhotoOptions);

    /**
     * @return GetTagPhotosOptions
     */
    public function getGetTagPhotosOptions();

    /**
     * @param GetTagPhotosOptions $getTagPhotosOptions
     *
     * @return static
     */
    public function setGetTagPhotosOptions($getTagPhotosOptions);

    //</editor-fold>

    //<editor-fold desc="Validators">

    /**
     * @return Validator
     * @throws InvalidConfigException
     */
    public function getAddressBindingValidator();

    /**
     * @param mixed $addressBindingValidator
     *
     * @return static
     */
    public function setAddressBindingValidator($addressBindingValidator);

    /**
     * @return Validator
     * @throws InvalidConfigException
     */
    public function getAlbumValidator();

    /**
     * @param Validator $albumValidator
     *
     * @return static
     */
    public function setAlbumValidator($albumValidator);

    /**
     * @return Validator
     * @throws InvalidConfigException
     */
    public function getAuthorValidator();

    /**
     * @param mixed $authorValidator
     *
     * @return static
     */
    public function setAuthorValidator($authorValidator);

    /**
     * @return Validator
     * @throws InvalidConfigException
     */
    public function getPointValidator();

    /**
     * @param mixed $pointValidator
     *
     * @return static
     */
    public function setPointValidator($pointValidator);

    /**
     * @return Validator
     * @throws InvalidConfigException
     */
    public function getPhotoValidator();

    /**
     * @param mixed $photoValidator
     *
     * @return static
     */
    public function setPhotoValidator($photoValidator);

    /**
     * @return Validator
     * @throws InvalidConfigException
     */
    public function getImageValidator();

    /**
     * @param mixed $imageValidator
     *
     * @return static
     */
    public function setImageValidator($imageValidator);

    /**
     * @return Validator
     * @throws InvalidConfigException
     */
    public function getTagValidator();

    /**
     * @param Validator $tagValidator
     *
     * @return static
     */
    public function setTagValidator($tagValidator);

    //</editor-fold>
}