<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 27.02.2016
 * Time: 17:44
 */

namespace romkaChev\yandexFotki;


use romkaChev\yandexFotki\interfaces\IFactory;
use romkaChev\yandexFotki\models\AddressBinding;
use romkaChev\yandexFotki\models\Album;
use romkaChev\yandexFotki\models\AlbumPhotosCollection;
use romkaChev\yandexFotki\models\AlbumsCollection;
use romkaChev\yandexFotki\models\Author;
use romkaChev\yandexFotki\models\Image;
use romkaChev\yandexFotki\models\options\CreateAlbumOptions;
use romkaChev\yandexFotki\models\options\CreatePhotoOptions;
use romkaChev\yandexFotki\models\options\GetAlbumPhotosOptions;
use romkaChev\yandexFotki\models\options\GetTagPhotosOptions;
use romkaChev\yandexFotki\models\Photo;
use romkaChev\yandexFotki\models\Point;
use romkaChev\yandexFotki\models\Tag;
use romkaChev\yandexFotki\models\TagPhotosCollection;
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
    /** @var \romkaChev\yandexFotki\models\AddressBinding */
    private $addressBindingModel;
    /** @var Album */
    private $albumModel;
    /** @var \romkaChev\yandexFotki\models\AlbumsCollection */
    private $albumsCollectionModel;
    /** @var \romkaChev\yandexFotki\models\AlbumPhotosCollection */
    private $albumPhotosCollectionModel;
    /** @var \romkaChev\yandexFotki\models\Author */
    private $authorModel;
    /** @var \romkaChev\yandexFotki\models\Photo */
    private $photoModel;
    /** @var Tag */
    private $tagModel;
    /** @var \romkaChev\yandexFotki\models\TagPhotosCollection */
    private $tagPhotosCollectionModel;
    /** @var \romkaChev\yandexFotki\models\Point */
    private $pointModel;
    /** @var Image */
    private $imageModel;
    //</editor-fold>

    //<editor-fold desc="Options">
    /** @var \romkaChev\yandexFotki\models\options\CreateAlbumOptions */
    private $createAlbumOptions;
    /** @var GetAlbumPhotosOptions */
    private $getAlbumPhotosOptions;
    /** @var \romkaChev\yandexFotki\models\options\CreatePhotoOptions */
    private $createPhotoOptions;
    /** @var \romkaChev\yandexFotki\models\options\GetTagPhotosOptions */
    private $getTagPhotosOptions;
    //</editor-fold>

    //<editor-fold desc="Validators">
    /** @var Validator */
    private $addressBindingValidator;
    /** @var Validator */
    private $albumValidator;
    /** @var Validator */
    private $authorValidator;
    /** @var Validator */
    private $pointValidator;
    /** @var Validator */
    private $photoValidator;
    /** @var Validator */
    private $imageValidator;
    /** @var Validator */
    private $tagValidator;
    //</editor-fold>

    //<editor-fold desc="Models">

    /**
     * @inheritdoc
     */
    public function getAddressBindingModel()
    {
        $this->preProcessConfigurableItem('addressBindingModel', AddressBinding::className());

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
        $this->preProcessConfigurableItem('albumModel', Album::className());

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
    public function getAlbumsCollectionModel()
    {
        $this->preProcessConfigurableItem('albumsCollectionModel', AlbumsCollection::className());

        return $this->albumsCollectionModel;
    }

    /**
     * @inheritdoc
     */
    public function setAlbumsCollectionModel($albumsCollectionModel)
    {
        $this->albumsCollectionModel = $albumsCollectionModel;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getAlbumPhotosCollectionModel()
    {
        $this->preProcessConfigurableItem('albumPhotosCollectionModel', AlbumPhotosCollection::className());

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
        $this->preProcessConfigurableItem('authorModel', Author::className());

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
        $this->preProcessConfigurableItem('photoModel', Photo::className());

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
        $this->preProcessConfigurableItem('tagModel', Tag::className());

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
        $this->preProcessConfigurableItem('tagPhotosCollectionModel', TagPhotosCollection::className());

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
        $this->preProcessConfigurableItem('pointModel', Point::className());

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
        $this->preProcessConfigurableItem('imageModel', Image::className());

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
        $this->preProcessConfigurableItem('createAlbumOptions', CreateAlbumOptions::className());

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
        $this->preProcessConfigurableItem('getAlbumPhotosOptions', GetAlbumPhotosOptions::className());

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
        $this->preProcessConfigurableItem('createPhotoOptions', CreatePhotoOptions::className());

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
        $this->preProcessConfigurableItem('getTagPhotosOptions', GetTagPhotosOptions::className());

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
     * @return Validator
     */
    public function getAlbumValidator()
    {
        $this->preProcessConfigurableItem('albumValidator', Validator::className());

        return $this->albumValidator;
    }

    /**
     * @param Validator $albumValidator
     *
     * @return static
     */
    public function setAlbumValidator($albumValidator)
    {
        $this->albumValidator = $albumValidator;

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

    /**
     * @return Validator
     */
    public function getTagValidator()
    {
        $this->preProcessConfigurableItem('tagValidator', Validator::className());

        return $this->tagValidator;
    }

    /**
     * @param Validator $tagValidator
     *
     * @return static
     */
    public function setTagValidator($tagValidator)
    {
        $this->tagValidator = $tagValidator;

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