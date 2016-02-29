<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 15:39
 */

namespace romkaChev\yandexFotki\components;


use romkaChev\yandexFotki\interfaces\components\IAlbumComponent;
use romkaChev\yandexFotki\models\Album;
use romkaChev\yandexFotki\models\options\CreateAlbumOptions;
use romkaChev\yandexFotki\models\options\GetAlbumPhotosOptions;
use romkaChev\yandexFotki\models\options\GetAlbumsOptions;
use romkaChev\yandexFotki\models\Photo;
use romkaChev\yandexFotki\traits\YandexFotkiAccess;
use yii\base\Component;
use yii\base\InvalidParamException;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\httpclient\Request;
use yii\httpclient\Response;

/**
 * Class AlbumComponent
 *
 * @package romkaChev\yandexFotki\components
 */
final class AlbumComponent extends Component implements IAlbumComponent
{

    use YandexFotkiAccess;

    /**
     * todo password
     *
     * @param int|string $id
     *
     * @return \romkaChev\yandexFotki\models\Album
     */
    public function get($id)
    {
        $httpClient = $this->yandexFotki->getApiHttpClient();
        $request    = $httpClient->get("album/{$id}/", ['format' => 'json']);
        $response   = $request->send();

        $album = $this->yandexFotki->getFactory()->getAlbumModel();
        $album->loadWithData($response->getData(), true);

        return $album;
    }

    /**
     * @param int|string                                                  $id
     * @param \romkaChev\yandexFotki\models\options\GetAlbumPhotosOptions $options
     *
     * @return Photo[]
     */
    public function getPhotos($id, GetAlbumPhotosOptions $options = null)
    {
        $options = $options ?: GetAlbumPhotosOptions::createDefault();

        if (!$options->validate()) {
            throw new InvalidParamException(VarDumper::dumpAsString($options->getErrors()));
        }

        $models = [];

        $httpClient = $this->yandexFotki->getApiHttpClient();
        $request    = $httpClient->get("album/{$id}/photos/{$options->sort}/", [
            'format'   => 'json',
            'limit'    => $options->limit,
            'password' => $options->password
        ]);

        do {
            $response = $request->send();

            $photosCollection = $this->yandexFotki->getFactory()->getAlbumPhotosCollectionModel();
            $photosCollection->loadWithData($response->getData(), true);

            $models  = ArrayHelper::merge($models, $photosCollection->photos);
            $request = $httpClient->get($photosCollection->linkNext);

        } while ($photosCollection->linkNext);

        return $models;
    }

    /**
     * @param CreateAlbumOptions $options
     *
     * @return \romkaChev\yandexFotki\models\Album
     */
    public function create(CreateAlbumOptions $options)
    {
        if (!$options->validate()) {
            throw new InvalidParamException(VarDumper::dumpAsString($options->getErrors()));
        }

        $httpClient = $this->yandexFotki->getApiHttpClient();
        $request    = $httpClient->post("albums/", $options->toArray());
        $response   = $request->send();

        $album = $this->yandexFotki->getFactory()->getAlbumModel();
        $album->loadWithData($response->getData(), true);

        return $album;
    }

    /**
     * @param mixed $options
     *
     * @return Album
     */
    public function update($options)
    {
        // TODO: Implement update() method.
    }

    /**
     * @param mixed $data
     *
     * @return \romkaChev\yandexFotki\models\Album
     */
    public function delete($data)
    {
        // TODO: Implement delete() method.
    }

    /**
     * @inheritdoc
     */
    public function tree($id = null, GetAlbumsOptions $options = null)
    {
        $options = $options ?: GetAlbumsOptions::createDefault();

        if (!$options->validate()) {
            throw new InvalidParamException(VarDumper::dumpAsString($options->getErrors()));
        }

        $httpClient = $this->yandexFotki->getApiHttpClient();
        $request    = $httpClient->get("albums/{$options->sort}/", [
            'format' => 'json',
            'limit'  => $options->limit
        ]);

        /** @var \romkaChev\yandexFotki\models\Album[] $models */
        $models = [];
        do {
            $response = $request->send();

            $collection = $this->yandexFotki->getFactory()->getAlbumsCollectionModel();
            $collection->loadWithData($response->getData(), true);

            $models  = ArrayHelper::merge($models, $collection->albums);
            $request = $httpClient->get($collection->linkNext);

        } while ($collection->linkNext);

        /** @var Album[][] $map */
        $map = ArrayHelper::index($models, 'id', function (Album $model) {
            return $model->parentId ?: '_root';
        });

        $rootIds = ArrayHelper::getColumn(ArrayHelper::remove($map, '_root', []), 'id');
        foreach ($map as $parentId => $children) {
            $models[$parentId]->setChildren($children);
        }

        $tree = [];
        if ($id) {
            $tree = $models[$id]->getChildren();
        } else {
            foreach ($rootIds as $rootId) {
                $tree[$rootId] = $models[$rootId];
            }
        }

        return $tree;
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
            return $httpClient->get("album/{$id}/", ['format' => 'json']);
        }, $ids);

        $responses = $httpClient->batchSend($requests);

        /** @var Album[] $models */
        $models = array_map(function (Response $response) {
            $model = $this->yandexFotki->getFactory()->getAlbumModel();
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

            $requests[] = $httpClient->post("albums/", $options->toArray());
        }

        $responses = $httpClient->batchSend($requests);

        $models = [];
        foreach ($responses as $response) {
            $model = $this->yandexFotki->getFactory()->getAlbumModel();
            $model->loadWithData($response->getData(), true);

            $models[] = $model;
        };

        return ArrayHelper::index($models, 'id');
    }

    /**
     * @param $data
     *
     * @return Album[]
     */
    public function batchUpdate($data)
    {
        // TODO: Implement multiUpdate() method.
    }

    /**
     * @param $data
     *
     * @return \romkaChev\yandexFotki\models\Album[]
     */
    public function batchDelete($data)
    {
        // TODO: Implement multiDelete() method.
    }
}