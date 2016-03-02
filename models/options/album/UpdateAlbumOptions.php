<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 02.03.2016
 * Time: 12:55
 */

namespace romkaChev\yandexFotki\models\options\album;

use romkaChev\yandexFotki\models\AbstractModel;
use yii\helpers\ArrayHelper;


/**
 * Class UpdateAlbumOptions
 *
 * @package romkaChev\yandexFotki\models\options\album
 */
class UpdateAlbumOptions extends AbstractModel
{
    /** @var int */
    public $id;
    /** @var string */
    public $title;
    /** @var string */
    public $summary;
    /** @var string */
    public $password;
    /** @var int */
    public $parentId;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['id', 'integer'],
            ['id', 'required'],

            ['title', 'string', 'min' => 1],
            ['summary', 'string'],
            ['password', 'string'],
            ['parentId', 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        $data = parent::toArray($fields, $expand, $recursive);

        $data['links'] = array_combine(array_keys($data['_links']), ArrayHelper::getColumn($data['_links'], 'href'));

        unset($data['_links']);
        unset($data['parentId']);
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

        if ($this->parentId) {
            $links['album'] = "{$httpClient->baseUrl}/album/{$this->parentId}/";
        }

        return $links;
    }
}