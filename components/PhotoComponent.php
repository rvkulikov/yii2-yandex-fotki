<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 16:51
 */

namespace romkaChev\yandexFotki\components;


use romkaChev\yandexFotki\interfaces\components\IPhotoComponent;
use romkaChev\yandexFotki\models\options\photo\CreatePhotoOptions;
use romkaChev\yandexFotki\models\Photo;
use romkaChev\yandexFotki\traits\YandexFotkiAccess;
use yii\base\Component;
use yii\base\InvalidParamException;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\httpclient\Request;
use yii\httpclient\Response;

/**
 * Class PhotoComponent
 *
 * @package romkaChev\yandexFotki\components
 */
final class PhotoComponent extends Component implements IPhotoComponent
{

    use YandexFotkiAccess;

    /**
     * @inheritdoc
     */
    public function get($id)
    {
        $httpClient = $this->yandexFotki->getApiHttpClient();
        $request    = $httpClient->get("photo/{$id}/", ['format' => 'json']);
        $response   = $request->send();

        $photo = $this->yandexFotki->getFactory()->getPhotoModel();
        $photo->loadWithData($response->getData(), true);

        return $photo;
    }

    /**
     * @inheritdoc
     */
    public function create(CreatePhotoOptions $options)
    {
        if (!$options->validate()) {
            throw new InvalidParamException(VarDumper::dumpAsString($options->getErrors()));
        }

        $httpClient = $this->yandexFotki->getApiHttpClient();

        $data  = $options->toArray();
        $image = ArrayHelper::remove($data, 'image');

        $request = $httpClient->post("photos/", $data);
        $request->addFile('image', $image, [
            'fileName' => $data['title']
        ]);

        $response = $request->send();

        $photo = $this->yandexFotki->getFactory()->getPhotoModel();
        $photo->loadWithData($response->getData(), true);

        return $photo;
    }

    /**
     * @param mixed $options
     *
     * @return Photo
     */
    public function update($options)
    {
        // TODO: Implement update() method.
    }

    /**
     * @param mixed $data
     *
     * @return Photo
     */
    public function delete($data)
    {
        // TODO: Implement delete() method.
    }

    /**
     * todo password
     *
     * @inheritdoc
     */
    public function batchGet($ids)
    {
        $httpClient = $this->yandexFotki->getApiHttpClient();

        /** @var Request[] $requests */
        $requests = array_map(function ($id) use ($httpClient) {
            return $httpClient->get("photo/{$id}/", ['format' => 'json']);
        }, $ids);

        $responses = $httpClient->batchSend($requests);

        /** @var Photo[] $models */
        $models = array_map(function (Response $response) {
            $model = $this->yandexFotki->getFactory()->getPhotoModel();
            $model->loadWithData($response->getData(), true);

            return $model;
        }, $responses);

        return array_combine(ArrayHelper::getColumn($models, 'id'), $models);
    }

    /**
     * @inheritdoc
     */
    public function batchCreate(array $optionsArray)
    {
        $httpClient = $this->yandexFotki->getApiHttpClient();

        $requests = [];
        foreach ($optionsArray as $options) {
            if (!$options->validate()) {
                throw new InvalidParamException(VarDumper::dumpAsString($options->getErrors()));
            }

            $optionsArray = $options->toArray();
            $image        = ArrayHelper::remove($optionsArray, 'image');

            $request = $httpClient->post("photos/", $optionsArray);
            $request->addFile('image', $image, [
                'fileName' => $optionsArray['title']
            ]);

            $requests[] = $request;
        }

        $responses = $httpClient->batchSend($requests);

        $models = [];
        foreach ($responses as $response) {
            $model = $this->yandexFotki->getFactory()->getPhotoModel();
            $model->loadWithData($response->getData(), true);

            $models[] = $model;
        };

        return ArrayHelper::index($models, 'id');
    }

    /**
     * @param $data
     *
     * @return Photo[]
     */
    public function batchUpdate($data)
    {
        // TODO: Implement batchUpdate() method.
    }

    /**
     * @param $data
     *
     * @return Photo[]
     */
    public function batchDelete($data)
    {
        // TODO: Implement batchDelete() method.
    }
}