<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 16:51
 */

namespace romkaChev\yandexFotki\components;


use romkaChev\yandexFotki\interfaces\components\IPhotoComponent;
use romkaChev\yandexFotki\interfaces\models\IPhoto;
use romkaChev\yandexFotki\models\Photo;
use romkaChev\yandexFotki\traits\YandexFotkiAccess;
use yii\base\Component;
use yii\helpers\ArrayHelper;
use yii\httpclient\Request;
use yii\httpclient\Response;

class PhotoComponent extends Component implements IPhotoComponent
{

    use YandexFotkiAccess;

    /**
     * @param int|string $id
     *
     * @return Photo
     */
    public function get($id)
    {
        $httpClient = $this->yandexFotki->httpClient;
        $request    = $httpClient->get("photo/{$id}/", ['format' => 'json']);
        $response   = $request->send();

        $photo = $this->yandexFotki->getPhotoModel();
        $photo->loadWithData($response->getData());

        return $photo;
    }

    /**
     * @param mixed $data
     *
     * @return IPhoto
     */
    public function create($data)
    {
        // TODO: Implement create() method.
    }

    /**
     * @param mixed $data
     *
     * @return IPhoto
     */
    public function update($data)
    {
        // TODO: Implement update() method.
    }

    /**
     * @param mixed $data
     *
     * @return IPhoto
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
            return $httpClient->get("photo/{$id}/", ['format' => 'json']);
        }, $ids);

        $responses = $httpClient->batchSend($requests);

        /** @var IPhoto[] $models */
        $models = array_map(function (Response $response) {
            $model = $this->yandexFotki->photoModel;
            $model->loadWithData($response->getData());

            return $model;
        }, $responses);

        return array_combine(ArrayHelper::getColumn($models, 'id'), $models);
    }

    /**
     * @param $data
     *
     * @return IPhoto[]
     */
    public function batchCreate($data)
    {
        // TODO: Implement batchCreate() method.
    }

    /**
     * @param $data
     *
     * @return IPhoto[]
     */
    public function batchUpdate($data)
    {
        // TODO: Implement batchUpdate() method.
    }

    /**
     * @param $data
     *
     * @return IPhoto[]
     */
    public function batchDelete($data)
    {
        // TODO: Implement batchDelete() method.
    }
}