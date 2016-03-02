<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 27.02.2016
 * Time: 17:58
 */

namespace romkaChev\yandexFotki\models\options\album;

use romkaChev\yandexFotki\models\AbstractModel;
use yii\helpers\ArrayHelper;

/**
 * Class CreateAlbumOptions
 *
 * @package romkaChev\yandexFotki\models\options\album
 */
class CreateAlbumOptions extends AbstractModel
{

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
            ['title', 'string', 'min' => 1],
            ['title', 'required'],

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