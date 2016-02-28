<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 27.02.2016
 * Time: 18:38
 */

namespace romkaChev\yandexFotki\interfaces;


use romkaChev\yandexFotki\interfaces\models\AbstractAddressBinding;
use romkaChev\yandexFotki\interfaces\models\AbstractAlbum;
use romkaChev\yandexFotki\interfaces\models\AbstractAlbumPhotosCollection;
use romkaChev\yandexFotki\interfaces\models\AbstractAuthor;
use romkaChev\yandexFotki\interfaces\models\AbstractImage;
use romkaChev\yandexFotki\interfaces\models\AbstractPhoto;
use romkaChev\yandexFotki\interfaces\models\AbstractPoint;
use romkaChev\yandexFotki\interfaces\models\AbstractTag;
use romkaChev\yandexFotki\interfaces\models\AbstractTagPhotosCollection;
use romkaChev\yandexFotki\interfaces\models\options\AbstractCreateAlbumOptions;
use romkaChev\yandexFotki\interfaces\models\options\AbstractCreatePhotoOptions;
use romkaChev\yandexFotki\interfaces\models\options\AbstractGetAlbumPhotosOptions;
use romkaChev\yandexFotki\interfaces\models\options\AbstractGetTagPhotosOptions;
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
     * @return AbstractAddressBinding
     * @throws InvalidConfigException
     */
    public function getAddressBindingModel();

    /**
     * @param mixed $addressBindingModel
     * @return static
     */
    public function setAddressBindingModel($addressBindingModel);

    /**
     * @return AbstractAlbum
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
     * @return AbstractAlbumPhotosCollection
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
     * @return AbstractAuthor
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
     * @return AbstractPhoto
     * @throws InvalidConfigException
     */
    public function getPhotoModel();

    /**
     * @param mixed $photoModel
     * @return static
     */
    public function setPhotoModel($photoModel);

    /**
     * @return AbstractTag
     * @throws InvalidConfigException
     */
    public function getTagModel();

    /**
     * @param mixed $tagModel
     * @return static
     */
    public function setTagModel($tagModel);

    /**
     * @return AbstractTagPhotosCollection
     */
    public function getTagPhotosCollectionModel();

    /**
     * @param AbstractTagPhotosCollection $tagPhotosCollectionModel
     *
     * @return static
     */
    public function setTagPhotosCollectionModel($tagPhotosCollectionModel);

    /**
     * @return AbstractPoint
     * @throws InvalidConfigException
     */
    public function getPointModel();

    /**
     * @param mixed $pointModel
     * @return static
     */
    public function setPointModel($pointModel);

    /**
     * @return AbstractImage
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
     * @return AbstractCreateAlbumOptions
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
     * @return AbstractGetAlbumPhotosOptions
     * @throws InvalidConfigException
     */
    public function getGetAlbumPhotosOptions();

    /**
     * @param mixed $getAlbumPhotosOptions
     * @return static
     */
    public function setGetAlbumPhotosOptions($getAlbumPhotosOptions);

    /**
     * @return AbstractCreatePhotoOptions
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
     * @return AbstractGetTagPhotosOptions
     */
    public function getGetTagPhotosOptions();

    /**
     * @param AbstractGetTagPhotosOptions $getTagPhotosOptions
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

    //</editor-fold>
}