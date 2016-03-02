<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 02.03.2016
 * Time: 13:00
 */

namespace romkaChev\yandexFotki\models\options;


use romkaChev\yandexFotki\models\AbstractModel;
use yii\helpers\ArrayHelper;
use yii\web\Linkable;

/**
 * Class AbstractSaveAlbumOptions
 *
 * @package romkaChev\yandexFotki\models\options
 */
abstract class AbstractSaveAlbumOptions extends AbstractModel implements Linkable
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