<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 16:51
 */

namespace romkaChev\yandexFotki\components;


use romkaChev\yandexFotki\interfaces\components\ITagComponent;
use romkaChev\yandexFotki\interfaces\models\AbstractTag;
use romkaChev\yandexFotki\traits\YandexFotkiAccess;
use yii\base\Component;
use yii\helpers\ArrayHelper;
use yii\httpclient\Request;
use yii\httpclient\Response;

/**
 * Class TagComponent
 *
 * @package romkaChev\yandexFotki\components
 */
final class TagComponent extends Component implements ITagComponent
{

    use YandexFotkiAccess;

    /**
     * @inheritdoc
     */
    public function get($id)
    {
        $httpClient = $this->yandexFotki->getHttpClient();
        $request    = $httpClient->get("tag/{$id}/", ['format' => 'json']);
        $response   = $request->send();

        $tag = $this->yandexFotki->getFactory()->getTagModel();
        $tag->loadWithData($response->getData());

        return $tag;
    }

    /**
     * @param mixed $options
     *
     * @return AbstractTag
     */
    public function create($options)
    {
        // TODO: Implement create() method.
    }

    /**
     * @param mixed $options
     *
     * @return AbstractTag
     */
    public function update($options)
    {
        // TODO: Implement update() method.
    }

    /**
     * @param mixed $data
     *
     * @return AbstractTag
     */
    public function delete($data)
    {
        // TODO: Implement delete() method.
    }

    /**
     * @inheritdoc
     */
    public function batchGet($ids)
    {
        $httpClient = $this->yandexFotki->getHttpClient();

        /** @var Request[] $requests */
        $requests = array_map(function ($id) use ($httpClient) {
            return $httpClient->get("tag/{$id}/", ['format' => 'json']);
        }, $ids);

        $responses = $httpClient->batchSend($requests);

        /** @var AbstractTag[] $models */
        $models = array_map(function (Response $response) {
            $model = $this->yandexFotki->getFactory()->getTagModel();
            $model->loadWithData($response->getData());

            return $model;
        }, $responses);

        return array_combine(ArrayHelper::getColumn($models, 'id'), $models);
    }

    /**
     * @param $data
     *
     * @return AbstractTag[]
     */
    public function batchCreate($data)
    {
        // TODO: Implement batchCreate() method.
    }

    /**
     * @param $data
     *
     * @return AbstractTag[]
     */
    public function batchUpdate($data)
    {
        // TODO: Implement batchUpdate() method.
    }

    /**
     * @param $data
     *
     * @return AbstractTag[]
     */
    public function batchDelete($data)
    {
        // TODO: Implement batchDelete() method.
    }
}