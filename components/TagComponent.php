<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 16:51
 */

namespace romkaChev\yandexFotki\components;


use romkaChev\yandexFotki\interfaces\components\ITagComponent;
use romkaChev\yandexFotki\models\options\tag\GetTagPhotosOptions;
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
     * @param mixed $options
     *
     * @return Tag
     */
    public function update($options)
    {
        // TODO: Implement update() method.
    }

    /**
     * @param mixed $data
     *
     * @return Tag
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
     * @param $data
     *
     * @return Tag[]
     */
    public function batchUpdate($data)
    {
        // TODO: Implement batchUpdate() method.
    }

    /**
     * @param $data
     *
     * @return Tag[]
     */
    public function batchDelete($data)
    {
        // TODO: Implement batchDelete() method.
    }
}