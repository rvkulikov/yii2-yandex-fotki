<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 9:50
 */

namespace romkaChev\yandexFotki\models;

use DateTime;
use romkaChev\yandexFotki\traits\parsers\AlbumsParser;
use romkaChev\yandexFotki\traits\parsers\AuthorParser;
use romkaChev\yandexFotki\traits\parsers\DateParser;
use yii\helpers\ArrayHelper;

/**
 * Class AbstractAlbumsCollection
 *
 * @package romkaChev\yandexFotki\interfaces\models
 */
class AlbumsCollection extends AbstractModel
{

    use AuthorParser, DateParser, AlbumsParser;

    /** @var string */
    public $urn;
    /** @var Author */
    public $author;
    /** @var string */
    public $title;
    /** @var DateTime */
    public $updatedAt;
    /** @var string */
    public $linkSelf;
    /** @var string */
    public $linkNext;
    /** @var string */
    public $linkAlternate;
    /** @var int */
    public $imageCount;
    /** @var Photo[] */
    public $albums;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['urn', 'string'],
            ['author', $this->getYandexFotki()->getFactory()->getAuthorValidator()],
            ['title', 'string'],
            ['updatedAt', 'string'],
            ['linkSelf', 'url'],
            ['linkNext', 'url'],
            ['linkAlternate', 'url'],
            ['albums', 'each', 'rule' => [$this->getYandexFotki()->getFactory()->getAlbumValidator()]]
        ];
    }

    /**
     * @inheritdoc
     */
    public function loadWithData($data, $fast = false)
    {
        $factory    = $this->getYandexFotki()->getFactory();
        $attributes = [
            'urn'           => ArrayHelper::getValue($data, 'id'),
            'author'        => ArrayHelper::getValue($data, $this->getAuthorParser('authors.0', $factory->getAuthorModel(), $fast)),
            'title'         => ArrayHelper::getValue($data, 'title'),
            'updatedAt'     => ArrayHelper::getValue($data, $this->getDateParser('updated', $this->getYandexFotki()->getFormatter())),
            'linkSelf'      => ArrayHelper::getValue($data, 'links.self'),
            'linkNext'      => ArrayHelper::getValue($data, 'links.next'),
            'linkAlternate' => ArrayHelper::getValue($data, 'links.alternate'),
            'albums'        => ArrayHelper::getValue($data, $this->getAlbumsParser('entries', $factory->getAlbumModel(), $fast))
        ];

        if ($fast) {
            \Yii::configure($this, $attributes);
        } else {
            $this->load([$this->formName() => $attributes]);
        }

        return $this;
    }
}