<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 27.02.2016
 * Time: 17:44
 */

namespace romkaChev\yandexFotki;


use romkaChev\yandexFotki\interfaces\IFactory;
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
use romkaChev\yandexFotki\traits\YandexFotkiAccess;
use yii\base\Component;
use yii\helpers\ArrayHelper;
use yii\validators\Validator;

/**
 * Class Factory
 *
 * @package romkaChev\yandexFotki
 */
final class Factory extends Component implements IFactory
{

    use YandexFotkiAccess;

    //<editor-fold desc="Models">
    private $addressBindingModel;
    private $albumModel;
    private $albumPhotosCollectionModel;
    private $authorModel;
    private $photoModel;
    private $tagModel;
    private $pointModel;
    private $imageModel;
    //</editor-fold>

    //<editor-fold desc="Options">
    private $createAlbumOptions;
    private $getAlbumPhotosOptions;
    //</editor-fold>

    //<editor-fold desc="Validators">
    private $addressBindingValidator;
    private $authorValidator;
    private $pointValidator;
    private $photoValidator;
    private $imageValidator;
    //</editor-fold>

    //<editor-fold desc="Models">

    /**
     * @inheritdoc
     */
    public function getAddressBindingModel()
    {
        if (!$this->addressBindingModel instanceof AbstractAddressBinding) {
            $this->addressBindingModel = \Yii::createObject($this->injectYandexFotki($this->addressBindingModel));
        }

        return clone $this->addressBindingModel;
    }

    /**
     * @inheritdoc
     */
    public function getAlbumModel()
    {
        if (!$this->albumModel instanceof AbstractAlbum) {
            $this->albumModel = \Yii::createObject($this->injectYandexFotki($this->albumModel));
        }

        return clone $this->albumModel;
    }

    /**
     * @inheritdoc
     */
    public function getAlbumPhotosCollectionModel()
    {
        if (!$this->albumPhotosCollectionModel instanceof AbstractAlbumPhotosCollection) {
            $this->albumPhotosCollectionModel = \Yii::createObject($this->injectYandexFotki($this->albumPhotosCollectionModel));
        }

        return clone $this->albumPhotosCollectionModel;
    }

    /**
     * @inheritdoc
     */
    public function getAuthorModel()
    {
        if (!$this->authorModel instanceof AbstractAuthor) {
            $this->authorModel = \Yii::createObject($this->injectYandexFotki($this->authorModel));
        }

        return clone $this->authorModel;
    }

    /**
     * @inheritdoc
     */
    public function getPhotoModel()
    {
        if (!$this->photoModel instanceof AbstractPhoto) {
            $this->photoModel = \Yii::createObject($this->injectYandexFotki($this->photoModel));
        }

        return clone $this->photoModel;
    }

    /**
     * @inheritdoc
     */
    public function getTagModel()
    {
        if (!$this->tagModel instanceof AbstractTag) {
            $this->tagModel = \Yii::createObject($this->injectYandexFotki($this->tagModel));
        }

        return clone $this->tagModel;
    }

    /**
     * @inheritdoc
     */
    public function getPointModel()
    {
        if (!$this->pointModel instanceof AbstractPoint) {
            $this->pointModel = \Yii::createObject($this->injectYandexFotki($this->pointModel));
        }

        return clone $this->pointModel;
    }

    /**
     * @inheritdoc
     */
    public function getImageModel()
    {
        if (!$this->imageModel instanceof AbstractImage) {
            $this->imageModel = \Yii::createObject($this->injectYandexFotki($this->imageModel));
        }

        return clone $this->imageModel;
    }

    /**
     * @inheritdoc
     */
    public function setAddressBindingModel($addressBindingModel)
    {
        $this->addressBindingModel = $addressBindingModel;
    }

    /**
     * @inheritdoc
     */
    public function setAlbumModel($albumModel)
    {
        $this->albumModel = $albumModel;
    }

    /**
     * @inheritdoc
     */
    public function setAlbumPhotosCollectionModel($albumPhotosCollectionModel)
    {
        $this->albumPhotosCollectionModel = $albumPhotosCollectionModel;
    }

    /**
     * @inheritdoc
     */
    public function setAuthorModel($authorModel)
    {
        $this->authorModel = $authorModel;
    }

    /**
     * @inheritdoc
     */
    public function setPhotoModel($photoModel)
    {
        $this->photoModel = $photoModel;
    }

    /**
     * @inheritdoc
     */
    public function setTagModel($tagModel)
    {
        $this->tagModel = $tagModel;
    }

    /**
     * @inheritdoc
     */
    public function setPointModel($pointModel)
    {
        $this->pointModel = $pointModel;
    }

    /**
     * @inheritdoc
     */
    public function setImageModel($imageModel)
    {
        $this->imageModel = $imageModel;
    }

    //</editor-fold>

    //<editor-fold desc="Options">

    /**
     * @inheritdoc
     */
    public function getCreateAlbumOptions()
    {
        if (!$this->createAlbumOptions instanceof AbstractCreateAlbumOptions) {
            $this->createAlbumOptions = \Yii::createObject($this->injectYandexFotki($this->createAlbumOptions));
        }

        return clone $this->createAlbumOptions;
    }

    /**
     * @inheritdoc
     */
    public function getGetAlbumPhotosOptions()
    {
        if (!$this->getAlbumPhotosOptions instanceof AbstractGetAlbumPhotosOptions) {
            $this->getAlbumPhotosOptions = \Yii::createObject($this->injectYandexFotki($this->getAlbumPhotosOptions));
        }

        return $this->getAlbumPhotosOptions;
    }

    /**
     * @inheritdoc
     */
    public function setCreateAlbumOptions($createAlbumOptions)
    {
        $this->createAlbumOptions = $createAlbumOptions;
    }

    /**
     * @inheritdoc
     */
    public function setGetAlbumPhotosOptions($getAlbumPhotosOptions)
    {
        $this->getAlbumPhotosOptions = $getAlbumPhotosOptions;
    }

    //</editor-fold>

    //<editor-fold desc="Validators">

    /**
     * @return Validator
     * @throws \yii\base\InvalidConfigException
     */
    public function getAddressBindingValidator()
    {
        if (!$this->addressBindingValidator instanceof Validator) {
            $this->addressBindingValidator = \Yii::createObject($this->addressBindingValidator);
        }

        return $this->addressBindingValidator;
    }

    /**
     * @return Validator
     * @throws \yii\base\InvalidConfigException
     */
    public function getAuthorValidator()
    {
        if (!$this->authorValidator instanceof Validator) {
            $this->authorValidator = \Yii::createObject($this->authorValidator);
        }

        return $this->authorValidator;
    }

    /**
     * @return Validator
     * @throws \yii\base\InvalidConfigException
     */
    public function getPointValidator()
    {
        if (!$this->pointValidator instanceof Validator) {
            $this->pointValidator = \Yii::createObject($this->pointValidator);
        }

        return $this->pointValidator;
    }

    /**
     * @return Validator
     * @throws \yii\base\InvalidConfigException
     */
    public function getPhotoValidator()
    {
        if (!$this->photoValidator instanceof Validator) {
            $this->photoValidator = \Yii::createObject($this->photoValidator);
        }

        return $this->photoValidator;
    }

    /**
     * @return Validator
     * @throws \yii\base\InvalidConfigException
     */
    public function getImageValidator()
    {
        if (!$this->imageValidator instanceof Validator) {
            $this->imageValidator = \Yii::createObject($this->imageValidator);
        }

        return $this->imageValidator;
    }

    /**
     * @param mixed $addressBindingValidator
     */
    public function setAddressBindingValidator($addressBindingValidator)
    {
        $this->addressBindingValidator = $addressBindingValidator;
    }

    /**
     * @param mixed $authorValidator
     */
    public function setAuthorValidator($authorValidator)
    {
        $this->authorValidator = $authorValidator;
    }

    /**
     * @param mixed $pointValidator
     */
    public function setPointValidator($pointValidator)
    {
        $this->pointValidator = $pointValidator;
    }

    /**
     * @param mixed $photoValidator
     */
    public function setPhotoValidator($photoValidator)
    {
        $this->photoValidator = $photoValidator;
    }

    /**
     * @param mixed $imageValidator
     */
    public function setImageValidator($imageValidator)
    {
        $this->imageValidator = $imageValidator;
    }

    //</editor-fold>

    /**
     * @param mixed $config
     *
     * @return array
     */
    protected function injectYandexFotki($config)
    {
        $config                = is_string($config) ? ['class' => $config] : $config;
        $config['yandexFotki'] = ArrayHelper::getValue($config, 'yandexFotki', $this->getYandexFotki());

        return $config;
    }
}