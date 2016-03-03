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
use romkaChev\yandexFotki\models\options\album\CreateAlbumOptions;
use romkaChev\yandexFotki\models\options\album\DeleteAlbumOptions;
use romkaChev\yandexFotki\models\options\album\GetAlbumPhotosOptions;
use romkaChev\yandexFotki\models\options\album\GetAlbumsOptions;
use romkaChev\yandexFotki\models\options\album\UpdateAlbumOptions;
use romkaChev\yandexFotki\models\options\photo\CreatePhotoOptions;
use romkaChev\yandexFotki\models\options\photo\DeletePhotoOptions;
use romkaChev\yandexFotki\models\options\photo\UpdatePhotoOptions;
use romkaChev\yandexFotki\models\options\tag\DeleteTagOptions;
use romkaChev\yandexFotki\models\options\tag\GetTagPhotosOptions;
use romkaChev\yandexFotki\models\options\tag\UpdateTagOptions;
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
    /** @var AddressBinding */
    private $addressBindingModel;
    /** @var Album */
    private $albumModel;
    /** @var AlbumsCollection */
    private $albumsCollectionModel;
    /** @var AlbumPhotosCollection */
    private $albumPhotosCollectionModel;
    /** @var Author */
    private $authorModel;
    /** @var Photo */
    private $photoModel;
    /** @var Tag */
    private $tagModel;
    /** @var TagPhotosCollection */
    private $tagPhotosCollectionModel;
    /** @var Point */
    private $pointModel;
    /** @var Image */
    private $imageModel;
    //</editor-fold>

    //<editor-fold desc="Options">
    /** @var GetAlbumsOptions */
    private $getAlbumsOptions;
    /** @var GetAlbumPhotosOptions */
    private $getAlbumPhotosOptions;
    /** @var CreateAlbumOptions */
    private $createAlbumOptions;
    /** @var UpdateAlbumOptions */
    private $updateAlbumOptions;
    /** @var DeleteAlbumOptions */
    private $deleteAlbumOptions;

    /** @var CreatePhotoOptions */
    private $createPhotoOptions;
    /** @var UpdatePhotoOptions */
    private $updatePhotoOptions;
    /** @var DeletePhotoOptions */
    private $deletePhotoOptions;

    /** @var GetTagPhotosOptions */
    private $getTagPhotosOptions;
    /** @var UpdateTagOptions */
    private $updateTagOptions;
    /** @var DeleteTagOptions */
    private $deleteTagOptions;
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
    public function getGetAlbumsOptions()
    {
        $this->preProcessConfigurableItem('getAlbumsOptions', GetAlbumsOptions::className());

        return clone $this->getAlbumsOptions;
    }

    /**
     * @inheritdoc
     */
    public function setGetAlbumsOptions($getAlbumsOptions)
    {
        $this->getAlbumsOptions = $getAlbumsOptions;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getGetAlbumPhotosOptions()
    {
        $this->preProcessConfigurableItem('getAlbumPhotosOptions', GetAlbumPhotosOptions::className());

        return clone $this->getAlbumPhotosOptions;
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
    public function getUpdateAlbumOptions()
    {
        $this->preProcessConfigurableItem('updateAlbumOptions', UpdateAlbumOptions::className());

        return clone $this->updateAlbumOptions;
    }

    /**
     * @inheritdoc
     */
    public function setUpdateAlbumOptions($updateAlbumOptions)
    {
        $this->updateAlbumOptions = $updateAlbumOptions;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getDeleteAlbumOptions()
    {
        $this->preProcessConfigurableItem('deleteAlbumOptions', DeleteAlbumOptions::className());

        return clone $this->deleteAlbumOptions;
    }

    /**
     * @inheritdoc
     */
    public function setDeleteAlbumOptions($deleteAlbumOptions)
    {
        $this->deleteAlbumOptions = $deleteAlbumOptions;

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
     * @return UpdatePhotoOptions
     */
    public function getUpdatePhotoOptions()
    {
        $this->preProcessConfigurableItem('updatePhotoOptions', UpdatePhotoOptions::className());

        return clone $this->updatePhotoOptions;
    }

    /**
     * @param UpdatePhotoOptions $updatePhotoOptions
     *
     * @return static
     */
    public function setUpdatePhotoOptions($updatePhotoOptions)
    {
        $this->updatePhotoOptions = $updatePhotoOptions;

        return $this;
    }

    /**
     * @return DeletePhotoOptions
     */
    public function getDeletePhotoOptions()
    {
        $this->preProcessConfigurableItem('deletePhotoOptions', DeletePhotoOptions::className());

        return clone $this->deletePhotoOptions;
    }

    /**
     * @param DeletePhotoOptions $deletePhotoOptions
     *
     * @return static
     */
    public function setDeletePhotoOptions($deletePhotoOptions)
    {
        $this->deletePhotoOptions = $deletePhotoOptions;

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

    /**
     * @return UpdateTagOptions
     */
    public function getUpdateTagOptions()
    {
        $this->preProcessConfigurableItem('updateTagOptions', UpdateTagOptions::className());

        return clone $this->updateTagOptions;
    }

    /**
     * @param mixed $updateTagOptions
     *
     * @return static
     */
    public function setUpdateTagOptions($updateTagOptions)
    {
        $this->updateTagOptions = $updateTagOptions;

        return $this;
    }

    /**
     * @return DeleteTagOptions
     */
    public function getDeleteTagOptions()
    {
        $this->preProcessConfigurableItem('deleteTagOptions', DeleteTagOptions::className());

        return clone $this->deleteTagOptions;
    }

    /**
     * @param mixed $deleteTagOptions
     *
     * @return static
     */
    public function setDeleteTagOptions($deleteTagOptions)
    {
        $this->deleteTagOptions = $deleteTagOptions;

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