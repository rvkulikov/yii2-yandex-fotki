<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 18.12.2015
 * Time: 22:12
 */

namespace romkaChev\yandexFotki\models;


use romkaChev\yandexFotki\interfaces\models\IAlbum;
use romkaChev\yandexFotki\interfaces\models\IAuthor;
use romkaChev\yandexFotki\traits\ModuleAccess;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Class Album
 *
 * @package romkaChev\yandexFotki\models
 *
 * @todo    cover
 */
class Album extends Model implements IAlbum
{
    use ModuleAccess;

    /** @var string */
    public $urn;
    /** @var int */
    public $id;
    /** @var Author */
    public $author;
    /** @var string */
    public $title;
    /** @var string */
    public $summary;
    /** @var bool */
    public $isProtected;
    /** todo this */
    public $cover;
    /** @var string */
    public $publishedAt;
    /** @var string */
    public $updatedAt;
    /** @var string */
    public $editedAt;
    /** @var string */
    public $linkSelf;
    /** @var string */
    public $linkEdit;
    /** @var string */
    public $linkPhotos;
    /** @var string */
    public $linkCover;
    /** @var string */
    public $linkYmapsml;
    /** @var string */
    public $linkAlternate;

    /**
     * @param array $data
     *
     * @return static
     */
    public function loadWithData($data)
    {
        $author = $this->getModule()->createAuthorModel();
        $author->loadWithData(ArrayHelper::getValue($data, 'authors.0'));

        $this->load([
            $this->formName() => [
                'urn'           => ArrayHelper::getValue($data, 'id'),
                'id'            => ArrayHelper::getValue($data, $this->getIdParser()),
                'author'        => $author,
                'title'         => ArrayHelper::getValue($data, 'title'),
                'summary'       => ArrayHelper::getValue($data, 'summary'),
                'isProtected'   => ArrayHelper::getValue($data, 'isProtected', false),
                'publishedAt'   => ArrayHelper::getValue($data, $this->getDateParser('published')),
                'updatedAt'     => ArrayHelper::getValue($data, $this->getDateParser('updated')),
                'editedAt'      => ArrayHelper::getValue($data, $this->getDateParser('edited')),
                'linkSelf'      => ArrayHelper::getValue($data, 'links.self'),
                'linkEdit'      => ArrayHelper::getValue($data, 'links.edit'),
                'linkPhotos'    => ArrayHelper::getValue($data, 'links.photos'),
                'linkCover'     => ArrayHelper::getValue($data, 'links.cover'),
                'linkYmapsml'   => ArrayHelper::getValue($data, 'links.ymapsml'),
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
            ['id', 'integer'],
            ['author', 'validateAuthor'],
            ['title', 'string'],
            ['summary', 'string'],
            ['isProtected', 'boolean'],
            ['publishedAt', 'string'],
            ['updatedAt', 'string'],
            ['editedAt', 'string'],
            ['linkSelf', 'url'],
            ['linkEdit', 'url'],
            ['linkPhotos', 'url'],
            ['linkCover', 'url'],
            ['linkYmapsml', 'url'],
            ['linkAlternate', 'url'],
            [['urn', 'id', 'author'], 'required'],
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
            preg_match('/^urn:yandex:fotki:flinnraider:album:(?<id>\d+)$/', $value, $matches);

            return intval(ArrayHelper::getValue($matches, 'id')) ?: $defaultValue;
        };
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