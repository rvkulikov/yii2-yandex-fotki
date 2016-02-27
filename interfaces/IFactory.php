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
use romkaChev\yandexFotki\interfaces\models\options\AbstractCreateAlbumOptions;
use romkaChev\yandexFotki\interfaces\models\options\AbstractGetAlbumPhotosOptions;
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
     * @return AbstractAlbum
     * @throws InvalidConfigException
     */
    public function getAlbumModel();

    /**
     * @return AbstractAlbumPhotosCollection
     * @throws InvalidConfigException
     */
    public function getAlbumPhotosCollectionModel();

    /**
     * @return AbstractAuthor
     * @throws InvalidConfigException
     */
    public function getAuthorModel();

    /**
     * @return AbstractPhoto
     * @throws InvalidConfigException
     */
    public function getPhotoModel();

    /**
     * @return AbstractTag
     * @throws InvalidConfigException
     */
    public function getTagModel();

    /**
     * @return AbstractPoint
     * @throws InvalidConfigException
     */
    public function getPointModel();

    /**
     * @return AbstractImage
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

    //</editor-fold>

    //<editor-fold desc="Options">

    /**
     * @return AbstractCreateAlbumOptions
     * @throws InvalidConfigException
     */
    public function getCreateAlbumOptions();

    /**
     * @return AbstractGetAlbumPhotosOptions
     * @throws InvalidConfigException
     */
    public function getGetAlbumPhotosOptions();

    /**
     * @param mixed $createAlbumOptions
     */
    public function setCreateAlbumOptions($createAlbumOptions);

    /**
     * @param mixed $getAlbumPhotosOptions
     */
    public function setGetAlbumPhotosOptions($getAlbumPhotosOptions);

    //</editor-fold>

    //<editor-fold desc="Validators">

    /**
     * @return Validator
     * @throws \yii\base\InvalidConfigException
     */
    public function getAddressBindingValidator();

    /**
     * @return Validator
     * @throws \yii\base\InvalidConfigException
     */
    public function getAuthorValidator();

    /**
     * @return Validator
     * @throws \yii\base\InvalidConfigException
     */
    public function getPointValidator();

    /**
     * @return Validator
     * @throws \yii\base\InvalidConfigException
     */
    public function getPhotoValidator();

    /**
     * @return Validator
     * @throws \yii\base\InvalidConfigException
     */
    public function getImageValidator();

    /**
     * @param mixed $addressBindingValidator
     */
    public function setAddressBindingValidator($addressBindingValidator);

    /**
     * @param mixed $authorValidator
     */
    public function setAuthorValidator($authorValidator);

    /**
     * @param mixed $pointValidator
     */
    public function setPointValidator($pointValidator);

    /**
     * @param mixed $photoValidator
     */
    public function setPhotoValidator($photoValidator);

    /**
     * @param mixed $imageValidator
     */
    public function setImageValidator($imageValidator);

    //</editor-fold>
}