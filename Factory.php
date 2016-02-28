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
use romkaChev\yandexFotki\interfaces\models\AbstractTagPhotosCollection;
use romkaChev\yandexFotki\interfaces\models\options\AbstractCreateAlbumOptions;
use romkaChev\yandexFotki\interfaces\models\options\AbstractCreatePhotoOptions;
use romkaChev\yandexFotki\interfaces\models\options\AbstractGetAlbumPhotosOptions;
use romkaChev\yandexFotki\interfaces\models\options\AbstractGetTagPhotosOptions;
use romkaChev\yandexFotki\traits\YandexFotkiAccess;
use yii\base\Component;
use yii\base\InvalidConfigException;
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
    /** @var AbstractAddressBinding */
    private $addressBindingModel;
    /** @var AbstractAlbum */
    private $albumModel;
    /** @var AbstractAlbumPhotosCollection */
    private $albumPhotosCollectionModel;
    /** @var AbstractAuthor */
    private $authorModel;
    /** @var AbstractPhoto */
    private $photoModel;
    /** @var AbstractTag */
    private $tagModel;
    /** @var AbstractTagPhotosCollection */
    private $tagPhotosCollectionModel;
    /** @var AbstractPoint */
    private $pointModel;
    /** @var AbstractImage */
    private $imageModel;
    //</editor-fold>

    //<editor-fold desc="Options">
    /** @var AbstractCreateAlbumOptions */
    private $createAlbumOptions;
    /** @var AbstractGetAlbumPhotosOptions */
    private $getAlbumPhotosOptions;
    /** @var AbstractCreatePhotoOptions */
    private $createPhotoOptions;
    /** @var AbstractGetTagPhotosOptions */
    private $getTagPhotosOptions;
    //</editor-fold>

    //<editor-fold desc="Validators">
    /** @var Validator */
    private $addressBindingValidator;
    /** @var Validator */
    private $authorValidator;
    /** @var Validator */
    private $pointValidator;
    /** @var Validator */
    private $photoValidator;
    /** @var Validator */
    private $imageValidator;
    //</editor-fold>

    //<editor-fold desc="Models">

    /**
     * @inheritdoc
     */
    public function getAddressBindingModel()
    {
        $this->preProcessConfigurableItem('addressBindingModel', AbstractAddressBinding::className());

        return clone $this->addressBindingModel;
    }

    /**
     * @inheritdoc
     */
    public function setAddressBindingModel($addressBindingModel)
    {
        $this->addressBindingModel = $addressBindingModel;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getAlbumModel()
    {
        $this->preProcessConfigurableItem('albumModel', AbstractAlbum::className());

        return clone $this->albumModel;
    }

    /**
     * @inheritdoc
     */
    public function setAlbumModel($albumModel)
    {
        $this->albumModel = $albumModel;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getAlbumPhotosCollectionModel()
    {
        $this->preProcessConfigurableItem('albumPhotosCollectionModel', AbstractAlbumPhotosCollection::className());

        return clone $this->albumPhotosCollectionModel;
    }

    /**
     * @inheritdoc
     */
    public function setAlbumPhotosCollectionModel($albumPhotosCollectionModel)
    {
        $this->albumPhotosCollectionModel = $albumPhotosCollectionModel;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getAuthorModel()
    {
        $this->preProcessConfigurableItem('authorModel', AbstractAuthor::className());

        return clone $this->authorModel;
    }

    /**
     * @inheritdoc
     */
    public function setAuthorModel($authorModel)
    {
        $this->authorModel = $authorModel;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getPhotoModel()
    {
        $this->preProcessConfigurableItem('photoModel', AbstractPhoto::className());

        return clone $this->photoModel;
    }

    /**
     * @inheritdoc
     */
    public function setPhotoModel($photoModel)
    {
        $this->photoModel = $photoModel;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getTagModel()
    {
        $this->preProcessConfigurableItem('tagModel', AbstractTag::className());

        return clone $this->tagModel;
    }

    /**
     * @inheritdoc
     */
    public function setTagModel($tagModel)
    {
        $this->tagModel = $tagModel;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getTagPhotosCollectionModel()
    {
        $this->preProcessConfigurableItem('tagPhotosCollectionModel', AbstractTagPhotosCollection::className());

        return $this->tagPhotosCollectionModel;
    }

    /**
     * @inheritdoc
     */
    public function setTagPhotosCollectionModel($tagPhotosCollectionModel)
    {
        $this->tagPhotosCollectionModel = $tagPhotosCollectionModel;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getPointModel()
    {
        $this->preProcessConfigurableItem('pointModel', AbstractPoint::className());

        return clone $this->pointModel;
    }

    /**
     * @inheritdoc
     */
    public function setPointModel($pointModel)
    {
        $this->pointModel = $pointModel;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getImageModel()
    {
        $this->preProcessConfigurableItem('imageModel', AbstractImage::className());

        return clone $this->imageModel;
    }

    /**
     * @inheritdoc
     */
    public function setImageModel($imageModel)
    {
        $this->imageModel = $imageModel;

        return $this;
    }

    //</editor-fold>

    //<editor-fold desc="Options">

    /**
     * @inheritdoc
     */
    public function getCreateAlbumOptions()
    {
        $this->preProcessConfigurableItem('createAlbumOptions', AbstractCreateAlbumOptions::className());

        return clone $this->createAlbumOptions;
    }

    /**
     * @inheritdoc
     */
    public function setCreateAlbumOptions($createAlbumOptions)
    {
        $this->createAlbumOptions = $createAlbumOptions;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getGetAlbumPhotosOptions()
    {
        $this->preProcessConfigurableItem('getAlbumPhotosOptions', AbstractGetAlbumPhotosOptions::className());

        return $this->getAlbumPhotosOptions;
    }

    /**
     * @inheritdoc
     */
    public function setGetAlbumPhotosOptions($getAlbumPhotosOptions)
    {
        $this->getAlbumPhotosOptions = $getAlbumPhotosOptions;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getCreatePhotoOptions()
    {
        $this->preProcessConfigurableItem('createPhotoOptions', AbstractCreatePhotoOptions::className());

        return clone $this->createPhotoOptions;
    }

    /**
     * @inheritdoc
     */
    public function setCreatePhotoOptions($createPhotoOptions)
    {
        $this->createPhotoOptions = $createPhotoOptions;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getGetTagPhotosOptions()
    {
        $this->preProcessConfigurableItem('getTagPhotosOptions', AbstractGetTagPhotosOptions::className());

        return clone $this->getTagPhotosOptions;
    }

    /**
     * @inheritdoc
     */
    public function setGetTagPhotosOptions($getTagPhotosOptions)
    {
        $this->getTagPhotosOptions = $getTagPhotosOptions;

        return $this;
    }

    //</editor-fold>

    //<editor-fold desc="Validators">

    /**
     * @inheritdoc
     */
    public function getAddressBindingValidator()
    {
        $this->preProcessConfigurableItem('addressBindingValidator', Validator::className());

        return $this->addressBindingValidator;
    }

    /**
     * @inheritdoc
     */
    public function setAddressBindingValidator($addressBindingValidator)
    {
        $this->addressBindingValidator = $addressBindingValidator;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getAuthorValidator()
    {
        $this->preProcessConfigurableItem('authorValidator', Validator::className());

        return $this->authorValidator;
    }

    /**
     * @inheritdoc
     */
    public function setAuthorValidator($authorValidator)
    {
        $this->authorValidator = $authorValidator;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getPointValidator()
    {
        $this->preProcessConfigurableItem('pointValidator', Validator::className());

        return $this->pointValidator;
    }

    /**
     * @inheritdoc
     */
    public function setPointValidator($pointValidator)
    {
        $this->pointValidator = $pointValidator;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getPhotoValidator()
    {
        $this->preProcessConfigurableItem('photoValidator', Validator::className());

        return $this->photoValidator;
    }

    /**
     * @inheritdoc
     */
    public function setPhotoValidator($photoValidator)
    {
        $this->photoValidator = $photoValidator;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getImageValidator()
    {
        $this->preProcessConfigurableItem('imageValidator', Validator::className());

        return $this->imageValidator;
    }

    /**
     * @inheritdoc
     */
    public function setImageValidator($imageValidator)
    {
        $this->imageValidator = $imageValidator;

        return $this;
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

    /**
     * @param string $attribute
     * @param string $instance
     *
     * @throws InvalidConfigException
     */
    protected function preProcessConfigurableItem($attribute, $instance)
    {
        if (!$this->{$attribute} instanceof $instance) {
            $this->{$attribute} = \Yii::createObject($this->injectYandexFotki($this->{$attribute}));

            if (!$this->{$attribute} instanceof $instance) {
                $type = get_class($this->{$attribute});
                throw new InvalidConfigException("'{$attribute}' must be an instance of '{$instance}', '{$type}' given.");
            }
        }
    }
}