<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 03.03.2016
 * Time: 16:00
 */

namespace romkaChev\yandexFotki\models\options\photo;


use romkaChev\yandexFotki\interfaces\models\IAccess;
use romkaChev\yandexFotki\models\AbstractModel;
use romkaChev\yandexFotki\models\Tag;
use yii\helpers\ArrayHelper;

/**
 * Class UpdatePhotoOptions
 *
 * @package romkaChev\yandexFotki\models\options\photo
 */
class UpdatePhotoOptions extends AbstractModel implements IAccess
{
    /** @var int */
    public $id;
    /** @var string */
    public $title;
    /** @var string */
    public $summary;
    /** @var boolean */
    public $isForAdult;
    /** @var boolean */
    public $disableComments;
    /** @var boolean */
    public $hideOriginal;
    /** @var string */
    public $access;
    /** @var int */
    public $albumId;
    /** @var string */
    public $tags;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //@formatter:off
            ['id', 'integer'],
            ['id', 'required'],

            ['title', 'string', 'min' => 1],

            ['summary', 'string'],

            ['hideOriginal',    'boolean'],
            ['isForAdult',      'boolean'],
            ['disableComments', 'boolean'],

            ['access', 'in', 'range' => [static::ACCESS_PUBLIC, static::ACCESS_FRIENDS, static::ACCESS_PRIVATE]],

            ['tags', 'filter', 'filter' => function($value){return $this->filterTags($value);}],
            ['tags', 'string'],

            ['albumId', 'integer'],
            //@formatter:on
        ];
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

        unset($data['_links']);
        unset($data['albumId']);
        unset($data['id']);

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