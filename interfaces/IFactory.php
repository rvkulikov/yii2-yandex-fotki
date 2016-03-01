<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 27.02.2016
 * Time: 18:38
 */

namespace romkaChev\yandexFotki\interfaces;


use romkaChev\yandexFotki\models\AddressBinding;
use romkaChev\yandexFotki\models\AlbumsCollection;
use romkaChev\yandexFotki\models\Image;
use romkaChev\yandexFotki\models\options\CreateAlbumOptions;
use romkaChev\yandexFotki\models\options\GetTagPhotosOptions;
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
     * @return static
     */
    public function setAddressBindingModel($addressBindingModel);

    /**
     * @return \romkaChev\yandexFotki\models\Album
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
     * @param \romkaChev\yandexFotki\models\AlbumsCollection $albumsCollectionModel
     *
     * @return static
     */
    public function setAlbumsCollectionModel($albumsCollectionModel);

    /**
     * @return \romkaChev\yandexFotki\models\AlbumPhotosCollection
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
     * @return \romkaChev\yandexFotki\models\Author
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
     * @return \romkaChev\yandexFotki\models\Photo
     * @throws InvalidConfigException
     */
    public function getPhotoModel();

    /**
     * @param mixed $photoModel
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
     * @return static
     */
    public function setTagModel($tagModel);

    /**
     * @return \romkaChev\yandexFotki\models\TagPhotosCollection
     */
    public function getTagPhotosCollectionModel();

    /**
     * @param TagPhotosCollection $tagPhotosCollectionModel
     *
     * @return static
     */
    public function setTagPhotosCollectionModel($tagPhotosCollectionModel);

    /**
     * @return \romkaChev\yandexFotki\models\Point
     * @throws InvalidConfigException
     */
    public function getPointModel();

    /**
     * @param mixed $pointModel
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
     * @return \romkaChev\yandexFotki\models\options\GetAlbumPhotosOptions
     * @throws InvalidConfigException
     */
    public function getGetAlbumPhotosOptions();

    /**
     * @param mixed $getAlbumPhotosOptions
     * @return static
     */
    public function setGetAlbumPhotosOptions($getAlbumPhotosOptions);

    /**
     * @return \romkaChev\yandexFotki\models\options\CreatePhotoOptions
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
     * @return \romkaChev\yandexFotki\models\options\GetTagPhotosOptions
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
     * @throws \yii\base\InvalidConfigException
     */
    public function getAddressBindingValidator();

    /**
     * @param mixed $addressBindingValidator
     * @return static
     */
    public function setAddressBindingValidator($addressBindingValidator);

    /**
     * @return Validator
     * @throws \yii\base\InvalidConfigException
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
     * @throws \yii\base\InvalidConfigException
     */
    public function getAuthorValidator();

    /**
     * @param mixed $authorValidator
     * @return static
     */
    public function setAuthorValidator($authorValidator);

    /**
     * @return Validator
     * @throws \yii\base\InvalidConfigException
     */
    public function getPointValidator();

    /**
     * @param mixed $pointValidator
     * @return static
     */
    public function setPointValidator($pointValidator);

    /**
     * @return Validator
     * @throws \yii\base\InvalidConfigException
     */
    public function getPhotoValidator();

    /**
     * @param mixed $photoValidator
     * @return static
     */
    public function setPhotoValidator($photoValidator);

    /**
     * @return Validator
     * @throws \yii\base\InvalidConfigException
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
     * @throws \yii\base\InvalidConfigException
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