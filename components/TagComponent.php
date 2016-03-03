<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 16:51
 */

namespace romkaChev\yandexFotki\components;


use romkaChev\yandexFotki\interfaces\components\ITagComponent;
use romkaChev\yandexFotki\models\options\tag\DeleteTagOptions;
use romkaChev\yandexFotki\models\options\tag\GetTagPhotosOptions;
use romkaChev\yandexFotki\models\options\tag\UpdateTagOptions;
use romkaChev\yandexFotki\models\Photo;
use romkaChev\yandexFotki\models\Tag;
use romkaChev\yandexFotki\traits\YandexFotkiAccess;
use yii\base\Component;
use yii\base\InvalidParamException;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\httpclient\Request;

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
        $id = urlencode($id);

        $httpClient = $this->yandexFotki->getApiHttpClient();
        $request    = $httpClient->get("tag/{$id}/", ['format' => 'json']);
        $response   = $request->send();

        $tag = $this->yandexFotki->getFactory()->getTagModel();
        $tag->loadWithData($response->getData(), true);

        return $tag;
    }

    /**
     * @inheritdoc
     */
    public function batchGet($ids)
    {
        $httpClient = $this->yandexFotki->getApiHttpClient();

        /** @var Request[] $requests */
        $requests = array_map(function ($id) use ($httpClient) {
            return $httpClient->get("tag/{$id}/", ['format' => 'json']);
        }, $ids);

        $responses = $httpClient->batchSend($requests);

        $models = [];
        foreach ($responses as $response) {
            $model = $this->yandexFotki->getFactory()->getTagModel();
            $model->loadWithData($response->getData(), true);

            $models[] = $model;
        };

        return ArrayHelper::index($models, 'id');
    }

    /**
     * @param int|string          $id
     * @param GetTagPhotosOptions $options
     *
     * @return Photo[]
     */
    public function getPhotos($id, GetTagPhotosOptions $options = null)
    {
        $id      = urlencode($id);
        $options = $options ?: GetTagPhotosOptions::createDefault();

        if (!$options->validate()) {
            throw new InvalidParamException(VarDumper::dumpAsString($options->getErrors()));
        }

        $photos = [];

        $httpClient = $this->yandexFotki->getApiHttpClient();
        $request    = $httpClient->get("tag/{$id}/photos/{$options->sort}/", [
            'format' => 'json',
            'limit'  => $options->limit
        ]);

        do {
            $response = $request->send();

            $photosCollection = $this->yandexFotki->getFactory()->getTagPhotosCollectionModel();
            $photosCollection->loadWithData($response->getData(), true);

            $photos  = ArrayHelper::merge($photos, $photosCollection->getPhotos());
            $request = $httpClient->get($photosCollection->linkNext);

        } while ($photosCollection->linkNext);

        return $photos;
    }

    /**
     * @param UpdateTagOptions $options
     *
     * @return Tag
     */
    public function update(UpdateTagOptions $options)
    {
        if (!$options->validate()) {
            throw new InvalidParamException(VarDumper::dumpAsString($options->getErrors()));
        }

        $httpClient = $this->yandexFotki->getApiHttpClient();

        $request = $httpClient->put("tag/{$options->id}", $options->toArray());

        $response = $request->send();

        $model = $this->yandexFotki->getFactory()->getTagModel();
        $model->loadWithData($response->getData(), true);

        return $model;
    }

    /**
     * @param UpdateTagOptions[] $optionsArray
     *
     * @return Tag[]
     */
    public function batchUpdate(array $optionsArray)
    {
        $httpClient = $this->yandexFotki->getApiHttpClient();

        $requests = [];
        foreach ($optionsArray as $options) {
            if (!$options->validate()) {
                throw new InvalidParamException(VarDumper::dumpAsString($options->getErrors()));
            }

            $requests[] = $httpClient->put("tag/{$options->id}/", $options->toArray());
        }

        $responses = $httpClient->batchSend($requests);

        $models = [];
        foreach ($responses as $response) {
            $model = $this->yandexFotki->getFactory()->getTagModel();
            $model->loadWithData($response->getData(), true);

            $models[] = $model;
        };

        return ArrayHelper::index($models, 'id');
    }

    /**
     * @param DeleteTagOptions $options
     *
     * @return boolean
     */
    public function delete(DeleteTagOptions $options)
    {
        if (!$options->validate()) {
            throw new InvalidParamException(VarDumper::dumpAsString($options->getErrors()));
        }

        $httpClient = $this->yandexFotki->getApiHttpClient();
        $request    = $httpClient->delete("tag/{$options->id}/");
        $response   = $request->send();

        return $response->isOk;
    }

    /**
     * @param DeleteTagOptions[] $optionsArray
     *
     * @return boolean[]
     */
    public function batchDelete(array $optionsArray)
    {
        $httpClient = $this->yandexFotki->getApiHttpClient();
        $requests   = [];
        foreach ($optionsArray as $options) {
            if (!$options->validate()) {
                throw new InvalidParamException(VarDumper::dumpAsString($options->getErrors()));
            }

            $requests[$options->id] = $httpClient->delete("tag/{$options->id}/");
        }
        $responses = $httpClient->batchSend($requests);

        return ArrayHelper::getColumn($responses, 'isOk');
    }
}