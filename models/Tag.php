<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 18.12.2015
 * Time: 22:43
 */

namespace romkaChev\yandexFotki\models;


use romkaChev\yandexFotki\interfaces\models\IAuthor;
use romkaChev\yandexFotki\interfaces\models\ITag;
use romkaChev\yandexFotki\traits\YandexFotkiAccess;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class Tag extends Model implements ITag
{
    use YandexFotkiAccess;

    /** @var string */
    public $urn;
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
     * @param array $data
     *
     * @return static
     */
    public function loadWithData($data)
    {
        $author = $this->getYandexFotki()->createAuthorModel();
        $author->loadWithData(ArrayHelper::getValue($data, 'authors.0'));

        $this->load([
            $this->formName() => [
                'urn'           => ArrayHelper::getValue($data, 'id'),
                'title'         => ArrayHelper::getValue($data, 'title'),
                'author'        => $author,
                'updatedAt'     => ArrayHelper::getValue($data, $this->getDateParser('updated')),
                'linkSelf'      => ArrayHelper::getValue($data, 'links.self'),
                'linkEdit'      => ArrayHelper::getValue($data, 'links.edit'),
                'linkPhotos'    => ArrayHelper::getValue($data, 'links.photos'),
                'linkAlternate' => ArrayHelper::getValue($data, 'links.alternate'),
            ],
        ]);

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['urn', 'string'],
            ['title', 'string'],
            ['author', 'validateAuthor'],
            ['updatedAt', 'string'],
            ['linkSelf', 'url'],
            ['linkEdit', 'url'],
            ['linkPhotos', 'url'],
            ['linkAlternate', 'url'],
            [['urn', 'name'], 'required'],
        ];
    }

    /**
     * @param mixed $attribute
     */
    public function validateAuthor($attribute)
    {
        if (!$this->$attribute instanceof IAuthor) {
            $instance = IAuthor::CLASS_NAME;
            $given    = gettype($this->$attribute);
            $this->addError($attribute, "The author must be an instance of {$instance}, {$given} given");
        }
    }

    /**
     * @param string $key
     *
     * @return \Closure
     */
    public function getDateParser($key)
    {
        /**
         * @param $array
         * @param $defaultValue
         *
         * @return mixed
         */
        return function ($array, $defaultValue) use ($key) {
            return \Yii::$app->formatter->asDate(ArrayHelper::getValue($array, $key)) ?: $defaultValue;
        };
    }
}