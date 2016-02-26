<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 18.12.2015
 * Time: 22:43
 */

namespace romkaChev\yandexFotki\models;


use romkaChev\yandexFotki\interfaces\models\ITag;
use romkaChev\yandexFotki\traits\parsers\AuthorParser;
use romkaChev\yandexFotki\traits\parsers\DateParser;
use romkaChev\yandexFotki\traits\YandexFotkiAccess;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Class Tag
 *
 * @package romkaChev\yandexFotki\models
 */
class Tag extends Model implements ITag
{
    use YandexFotkiAccess, DateParser, AuthorParser;

    /** @var string */
    public $urn;
    /** @var int */
    public $id;
    /** @var string */
    public $title;
    /** @var Author */
    public $author;
    /** @var string */
    public $updatedAt;
    /** @var string */
    public $linkSelf;
    /** @var string */
    public $linkEdit;
    /** @var string */
    public $linkPhotos;
    /** @var string */
    public $linkAlternate;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['urn', 'string'],
            ['id', 'string'],
            ['title', 'string'],
            ['author', $this->yandexFotki->authorValidator],
            ['updatedAt', 'string'],
            ['linkSelf', 'url'],
            ['linkEdit', 'url'],
            ['linkPhotos', 'url'],
            ['linkAlternate', 'url'],
        ];
    }

    /**
     * @param array $data
     *
     * @return static
     */
    public function loadWithData($data)
    {
        \Yii::configure($this, [
            'urn'           => ArrayHelper::getValue($data, 'id'),
            'id'            => ArrayHelper::getValue($data, $this->getIdParser()),
            'title'         => ArrayHelper::getValue($data, 'title'),
            'author'        => ArrayHelper::getValue($data, $this->getAuthorParser($this->yandexFotki->authorModel)),
            'updatedAt'     => ArrayHelper::getValue($data, $this->getDateParser('updated')),
            'linkSelf'      => ArrayHelper::getValue($data, 'links.self'),
            'linkEdit'      => ArrayHelper::getValue($data, 'links.edit'),
            'linkPhotos'    => ArrayHelper::getValue($data, 'links.photos'),
            'linkAlternate' => ArrayHelper::getValue($data, 'links.alternate'),
        ]);

        return $this;
    }

    /**
     * @return \Closure
     */
    public function getIdParser()
    {
        /**
         * @param $array
         * @param $defaultValue
         *
         * @return mixed
         */
        return function ($array, $defaultValue) {
            $value = ArrayHelper::getValue($array, 'id');
            preg_match('/^urn:yandex:fotki:([^:]*):tag:(?<id>.*)$/', $value, $matches);

            return ArrayHelper::getValue($matches, 'id') ?: $defaultValue;
        };
    }
}