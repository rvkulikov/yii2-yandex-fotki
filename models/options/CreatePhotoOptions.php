<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 28.02.2016
 * Time: 12:16
 */

namespace romkaChev\yandexFotki\models\options;


use romkaChev\yandexFotki\interfaces\models\IAccess;
use romkaChev\yandexFotki\models\AbstractModel;
use romkaChev\yandexFotki\models\Tag;
use yii\helpers\ArrayHelper;
use yii\web\Linkable;
use yii\web\UploadedFile;

/**
 * todo check is the password required for protected album
 *
 * Class AbstractCreatePhotoOptions
 *
 * @package romkaChev\yandexFotki\interfaces\models\options
 */
class CreatePhotoOptions extends AbstractModel implements Linkable, IAccess
{
    /** @var string */
    public $image;
    /** @var string */
    public $title;
    /** @var string */
    public $summary;
    /** @var boolean */
    public $hideOriginal;
    /** @var boolean */
    public $isForAdult;
    /** @var boolean */
    public $disableComments;
    /** @var string */
    public $access;
    /** @var string */
    public $tags;
    /** @var string */
    public $pubChannel;
    /** @var string */
    public $appPlatform;
    /** @var string */
    public $appVersion;
    /** @var int */
    public $albumId;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //@formatter:off
            ['title', 'string', 'min' => 1],
            ['title', 'default', 'value' => function(){return $this->defaultTitle();}],

            ['summary', 'string'],

            ['image', 'filter', 'filter' => function($value){return $this->filterImage($value);}],
            ['image', 'safe'],
            ['image', 'required'],

            ['hideOriginal',    'boolean'],
            ['isForAdult',      'boolean'],
            ['disableComments', 'boolean'],

            ['access', 'in', 'range' => [static::ACCESS_PUBLIC, static::ACCESS_FRIENDS, static::ACCESS_PRIVATE]],

            ['tags', 'filter', 'filter' => function($value){return $this->filterTags($value);}],
            ['tags', 'string'],

            ['pubChannel',  'string'],
            ['pubChannel',  'default', 'value' => function(){return $this->defaultPubChannel();}],

            ['appPlatform', 'string'],
            ['appPlatform', 'default', 'value' => function(){return $this->defaultAppPlatform();}],

            ['appVersion',  'string'],
            ['appVersion',  'default', 'value' => function(){return $this->defaultAppVersion();}],
            //@formatter:on
        ];
    }

    /**
     * @return string
     */
    public function defaultTitle()
    {
        return $this->image instanceof UploadedFile
            ? $this->image->name
            : basename($this->image);
    }

    /**
     * @return string
     */
    public function defaultPubChannel()
    {
        return $this->getYandexFotki()->getPubChannel();
    }

    /**
     * @return string
     */
    public function defaultAppPlatform()
    {
        return $this->getYandexFotki()->getAppPlatform();
    }

    /**
     * @return string
     */
    public function defaultAppVersion()
    {
        return $this->getYandexFotki()->getAppVersion();
    }

    /**
     * @param string|UploadedFile $value
     *
     * @return string
     */
    public function filterImage($value)
    {
        if ($value instanceof UploadedFile) {
            return $value->tempName;
        }

        return $value;
    }

    /**
     * @param string|array $value
     *
     * @return string
     */
    public function filterTags($value)
    {
        if (is_array($value)) {
            return implode(';', array_map(function ($tag) {
                return $tag instanceof Tag
                    ? $tag->title
                    : $tag;
            }, $value));
        }

        return $value;
    }

    /**
     * @inheritdoc
     */
    public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        $data = parent::toArray($fields, $expand, $recursive);

        $data['links'] = array_combine(array_keys($data['_links']), ArrayHelper::getColumn($data['_links'], 'href'));

        $data['hide_original']    = ArrayHelper::remove($data, 'hideOriginal');
        $data['xxx']              = ArrayHelper::remove($data, 'isForAdult');
        $data['disable_comments'] = ArrayHelper::remove($data, 'disableComments');
        $data['pub_channel']      = ArrayHelper::remove($data, 'pubChannel');
        $data['app_platform']     = ArrayHelper::remove($data, 'appPlatform');
        $data['app_version']      = ArrayHelper::remove($data, 'appVersion');

        unset($data['_links']);
        unset($data['albumId']);

        $data = array_filter($data);

        return $data;
    }

    /**
     * @inheritdoc
     */
    public function getLinks()
    {
        $httpClient = $this->getYandexFotki()->getApiHttpClient();
        $links      = [];

        if ($this->albumId) {
            $links['album'] = "{$httpClient->baseUrl}/album/{$this->albumId}/";
        }

        return $links;
    }
}