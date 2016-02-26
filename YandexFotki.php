<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 11:12
 */

namespace romkaChev\yandexFotki;


use InvalidArgumentException;
use romkaChev\yandexFotki\components\AlbumComponent;
use romkaChev\yandexFotki\components\PhotoComponent;
use romkaChev\yandexFotki\components\TagComponent;
use romkaChev\yandexFotki\interfaces\components\IAlbumComponent;
use romkaChev\yandexFotki\interfaces\components\IPhotoComponent;
use romkaChev\yandexFotki\interfaces\components\ITagComponent;
use romkaChev\yandexFotki\interfaces\IYandexFotki;
use romkaChev\yandexFotki\interfaces\models\IAddressBinding;
use romkaChev\yandexFotki\interfaces\models\IAlbum;
use romkaChev\yandexFotki\interfaces\models\IAlbumPhotosCollection;
use romkaChev\yandexFotki\interfaces\models\IAuthor;
use romkaChev\yandexFotki\interfaces\models\IImage;
use romkaChev\yandexFotki\interfaces\models\IPhoto;
use romkaChev\yandexFotki\interfaces\models\IPoint;
use romkaChev\yandexFotki\interfaces\models\ITag;
use romkaChev\yandexFotki\models\Album;
use romkaChev\yandexFotki\models\Author;
use romkaChev\yandexFotki\models\Image;
use romkaChev\yandexFotki\models\Photo;
use romkaChev\yandexFotki\models\Point;
use romkaChev\yandexFotki\models\Tag;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\caching\Cache;
use yii\caching\DummyCache;
use yii\helpers\ArrayHelper;
use yii\httpclient\Client;

/**
 * Class Module
 *
 * @package romkaChev\yandexFotki
 *
 * @property Client                 $httpClient
 * @property Cache                  $cache
 * @property AlbumComponent         $albums
 * @property PhotoComponent         $photos
 * @property TagComponent           $tags
 *
 * @property string|array           $addressBindingValidator
 * @property string|array           $authorValidator
 * @property string|array           $pointValidator
 * @property string|array           $photoValidator
 * @property string|array           $imageValidator
 *
 * @property IAddressBinding        $addressBindingModel
 * @property IAlbum                 $albumModel
 * @property IAlbumPhotosCollection $albumPhotosCollectionModel
 * @property IAuthor                $authorModel
 * @property IPhoto                 $photoModel
 * @property ITag                   $tagModel
 * @property IPoint                 $pointModel
 * @property IImage                 $imageModel
 */
class YandexFotki extends Component implements IYandexFotki
{
    public $login      = null;
    public $oauthToken = null;

    protected $addressBindingModel;
    protected $albumModel;
    protected $albumPhotosCollectionModel;
    protected $authorModel;
    protected $photoModel;
    protected $tagModel;
    protected $pointModel;
    protected $imageModel;

    private $_addressBindingValidator;
    private $_authorValidator;
    private $_pointValidator;
    private $_photoValidator;
    private $_imageValidator;

    /**
     * @var Client
     */
    private $_httpClient;
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
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $httpClient                 = $this->httpClient;
        $httpClient->baseUrl        = "http://api-fotki.yandex.ru/api/users/{$this->login}";
        $httpClient->requestConfig  = [
            'headers' => [
                'Content-Type'  => 'application/json; charset=utf-8; type=entry',
                'Authorization' => "OAuth {$this->oauthToken}",
            ],
        ];
        $httpClient->responseConfig = [
            'format' => $httpClient::FORMAT_JSON,
        ];
    }

    /**
     * @inheritdoc
     */
    public function setHttpClient($value)
    {

        if (!$value instanceof Client) {
            $value = \Yii::createObject($value);
        }

        if (!$value instanceof Client) {
            $instance = Client::className();
            $type     = gettype($value);
            throw new InvalidArgumentException("Value must be an instance of '{$instance}', '{$type}' given.");
        }

        $this->_httpClient = $value;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getHttpClient()
    {
        if (!$this->_httpClient) {
            throw new InvalidConfigException('HttpClient property was not specified');
        }

        return $this->_httpClient;
    }

    /**
     * @inheritdoc
     */
    public function setCache($value)
    {
        if (!$value instanceof Cache) {
            $value = \Yii::createObject($value);
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
     * @inheritdoc
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
     * @inheritdoc
     */
    public function setAlbums($value)
    {
        if (!$value instanceof IAlbumComponent) {
            $value = \Yii::createObject($value);
        }

        if (!$value instanceof IAlbumComponent) {
            $instance = IAlbumComponent::CLASS_NAME;
            $type     = gettype($value);
            throw new InvalidArgumentException("Value must be an instance of '{$instance}', '{$type}' given.");
        }

        $this->_albums = $value;

        if ($this->_albums->yandexFotki === null) {
            $this->_albums->yandexFotki = $this;
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getAlbums()
    {
        if (!$this->_albums) {
            throw new InvalidConfigException('Albums property was not specified');
        }

        return $this->_albums;
    }

    /**
     * @inheritdoc
     */
    public function setPhotos($value)
    {
        if (!$value instanceof IPhotoComponent) {
            $value = \Yii::createObject($value);
        }

        if (!$value instanceof IPhotoComponent) {
            $instance = IPhotoComponent::CLASS_NAME;
            $type     = gettype($value);
            throw new InvalidArgumentException("Value must be an instance of '{$instance}', '{$type}' given.");
        }

        $this->_photos = $value;

        if ($this->_photos->yandexFotki === null) {
            $this->_photos->yandexFotki = $this;
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getPhotos()
    {
        if (!$this->_photos) {
            throw new InvalidConfigException('Photos property was not specified');
        }

        return $this->_photos;
    }

    /**
     * @inheritdoc
     */
    public function setTags($value)
    {
        if (!$value instanceof ITagComponent) {
            $value = \Yii::createObject($value);
        }

        if (!$value instanceof ITagComponent) {
            $instance = ITagComponent::CLASS_NAME;
            $type     = gettype($value);
            throw new InvalidArgumentException("Value must be an instance of '{$instance}', '{$type}' given.");
        }

        $this->_tags = $value;

        if ($this->_tags->yandexFotki === null) {
            $this->_tags->yandexFotki = $this;
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getTags()
    {
        if (!$this->_tags) {
            throw new InvalidConfigException('Tags property was not specified');
        }

        return $this->_tags;
    }

    //region models

    /**
     * @inheritdoc
     */
    public function getAddressBindingModel()
    {
        if (!$this->addressBindingModel instanceof IAddressBinding) {
            $config                = is_string($this->addressBindingModel) ? ['class' => $this->addressBindingModel] : $this->addressBindingModel;
            $config['yandexFotki'] = ArrayHelper::getValue($config, 'yandexFotki', $this);

            $this->addressBindingModel = \Yii::createObject($config);
        }

        return clone $this->addressBindingModel;
    }

    /**
     * @inheritdoc
     */
    public function getAlbumModel()
    {
        if (!$this->albumModel instanceof Album) {
            $config                = is_string($this->albumModel) ? ['class' => $this->albumModel] : $this->albumModel;
            $config['yandexFotki'] = ArrayHelper::getValue($config, 'yandexFotki', $this);

            $this->albumModel = \Yii::createObject($config);
        }

        return clone $this->albumModel;
    }

    /**
     * @inheritdoc
     */
    public function getAlbumPhotosCollectionModel()
    {
        if (!$this->albumPhotosCollectionModel instanceof IAlbumPhotosCollection) {
            $config                = is_string($this->albumPhotosCollectionModel) ? ['class' => $this->albumPhotosCollectionModel] : $this->albumPhotosCollectionModel;
            $config['yandexFotki'] = ArrayHelper::getValue($config, 'yandexFotki', $this);

            $this->albumPhotosCollectionModel = \Yii::createObject($config);
        }

        return clone $this->albumPhotosCollectionModel;
    }

    /**
     * @inheritdoc
     */
    public function getAuthorModel($config = [])
    {
        if (!$this->authorModel instanceof Author) {
            $config                = is_string($this->authorModel) ? ['class' => $this->authorModel] : $this->authorModel;
            $config['yandexFotki'] = ArrayHelper::getValue($config, 'yandexFotki', $this);

            $this->authorModel = \Yii::createObject($config);
        }

        return clone $this->authorModel;
    }

    /**
     * @inheritdoc
     */
    public function getPhotoModel()
    {
        if (!$this->photoModel instanceof Photo) {
            $config                = is_string($this->photoModel) ? ['class' => $this->photoModel] : $this->photoModel;
            $config['yandexFotki'] = ArrayHelper::getValue($config, 'yandexFotki', $this);

            $this->photoModel = \Yii::createObject($config);
        }

        return clone $this->photoModel;
    }

    /**
     * @inheritdoc
     */
    public function getTagModel()
    {
        if (!$this->tagModel instanceof Tag) {
            $config                = is_string($this->tagModel) ? ['class' => $this->tagModel] : $this->tagModel;
            $config['yandexFotki'] = ArrayHelper::getValue($config, 'yandexFotki', $this);

            $this->tagModel = \Yii::createObject($config);
        }

        return clone $this->tagModel;
    }

    /**
     * @inheritdoc
     */
    public function getPointModel()
    {
        if (!$this->pointModel instanceof Point) {
            $config                = is_string($this->pointModel) ? ['class' => $this->pointModel] : $this->pointModel;
            $config['yandexFotki'] = ArrayHelper::getValue($config, 'yandexFotki', $this);

            $this->pointModel = \Yii::createObject($config);
        }

        return clone $this->pointModel;
    }

    /**
     * @inheritdoc
     */
    public function getImageModel()
    {
        if (!$this->imageModel instanceof Image) {
            $config                = is_string($this->imageModel) ? ['class' => $this->imageModel] : $this->imageModel;
            $config['yandexFotki'] = ArrayHelper::getValue($config, 'yandexFotki', $this);

            $this->imageModel = \Yii::createObject($config);
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

    //endregion

    public function setAddressBindingValidator($value)
    {
        $this->_addressBindingValidator = $value;
    }

    public function getAddressBindingValidator()
    {
        return $this->_addressBindingValidator;
    }

    public function setAuthorValidator($value)
    {
        $this->_authorValidator = $value;
    }

    public function getAuthorValidator()
    {
        return $this->_authorValidator;
    }

    public function setPointValidator($value)
    {
        $this->_pointValidator = $value;
    }

    public function getPointValidator()
    {
        return $this->_pointValidator;
    }

    public function setPhotoValidator($value)
    {
        $this->_photoValidator = $value;
    }

    public function getPhotoValidator()
    {
        return $this->_imageValidator;
    }

    public function setImageValidator($value)
    {
        $this->_imageValidator = $value;
    }

    public function getImageValidator()
    {
        return $this->_imageValidator;
    }
}