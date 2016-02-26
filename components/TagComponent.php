<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 16:51
 */

namespace romkaChev\yandexFotki\components;


use romkaChev\yandexFotki\interfaces\components\ITagComponent;
use romkaChev\yandexFotki\interfaces\models\ITag;
use romkaChev\yandexFotki\traits\YandexFotkiAccess;
use yii\base\Component;
use yii\helpers\ArrayHelper;
use yii\httpclient\Request;
use yii\httpclient\Response;

class TagComponent extends Component implements ITagComponent
{

    use YandexFotkiAccess;

    /**
     * @inheritdoc
     */
    public function get($id)
    {
        $httpClient = $this->yandexFotki->httpClient;
        $request    = $httpClient->get("tag/{$id}/", ['format' => 'json']);
        $response   = $request->send();

        $tag = $this->yandexFotki->getTagModel();
        $tag->loadWithData($response->getData());

        return $tag;
    }

    /**
     * @param mixed $data
     *
     * @return ITag
     */
    public function create($data)
    {
        // TODO: Implement create() method.
    }

    /**
     * @param mixed $data
     *
     * @return ITag
     */
    public function update($data)
    {
        // TODO: Implement update() method.
    }

    /**
     * @param mixed $data
     *
     * @return ITag
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
        $httpClient = $this->yandexFotki->httpClient;

        /** @var Request[] $requests */
        $requests = array_map(function ($id) use ($httpClient) {
            return $httpClient->get("tag/{$id}/", ['format' => 'json']);
        }, $ids);

        $responses = $httpClient->batchSend($requests);

        /** @var ITag[] $models */
        $models = array_map(function (Response $response) {
            $model = $this->yandexFotki->tagModel;
            $model->loadWithData($response->getData());

            return $model;
        }, $responses);

        return array_combine(ArrayHelper::getColumn($models, 'id'), $models);
    }

    /**
     * @param $data
     *
     * @return ITag[]
     */
    public function batchCreate($data)
    {
        // TODO: Implement batchCreate() method.
    }

    /**
     * @param $data
     *
     * @return ITag[]
     */
    public function batchUpdate($data)
    {
        // TODO: Implement batchUpdate() method.
    }

    /**
     * @param $data
     *
     * @return ITag[]
     */
    public function batchDelete($data)
    {
        // TODO: Implement batchDelete() method.
    }
}