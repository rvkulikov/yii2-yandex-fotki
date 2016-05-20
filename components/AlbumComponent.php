<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 15:39
 */

namespace romkaChev\yandexFotki\components;


use romkaChev\yandexFotki\exceptions\DangerousDeleteOperationException;
use romkaChev\yandexFotki\interfaces\components\IAlbumComponent;
use romkaChev\yandexFotki\models\Album;
use romkaChev\yandexFotki\models\options\album\CreateAlbumOptions;
use romkaChev\yandexFotki\models\options\album\DeleteAlbumOptions;
use romkaChev\yandexFotki\models\options\album\GetAlbumPhotosOptions;
use romkaChev\yandexFotki\models\options\album\GetAlbumsOptions;
use romkaChev\yandexFotki\models\options\album\UpdateAlbumOptions;
use romkaChev\yandexFotki\traits\YandexFotkiAccess;
use yii\base\Component;
use yii\base\InvalidParamException;
use yii\caching\Cache;
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

    public $albumKeyPattern       = 'urn:yandex:fotki:{login}:album:{id}';
    public $albumPhotosKeyPattern = 'urn:yandex:fotki:{login}:album:{id}:photos';

    /**
     * @var Cache
     */
    public $cache;
    /**
     * @var int
     */
    public $cacheExpires;

    /**
     * @inheritdoc
     */
    public function get($id)
    {
        $key = $this->getAlbumKey($id);

        if (($model = $this->cache->get($key)) === false) {
            $model = $this->getInternal($id);
            $this->cache->set($key, $model, $this->cacheExpires);
        }

        return $model;
    }

    /**
     * @inheritdoc
     */
    public function getInternal($id)
    {
        $httpClient = $this->yandexFotki->getApiHttpClient();
        $request    = $httpClient->get("album/{$id}/", ['format' => 'json']);
        $response   = $request->send();

        $album = $this->yandexFotki->getFactory()->getAlbumModel();
        $album->loadWithData($response->getData(), true);

        return $album;
    }

    /**
     * @inheritdoc
     */
    public function batchGet($ids)
    {
        $idsMap = [];
        foreach ($ids as $id) {
            $idsMap[$this->getAlbumKey($id)] = $id;
        }

        $models  = $this->cache->multiGet(array_keys($idsMap));
        $newKeys = array_keys(array_filter($models, function ($value) {
            return !$value;
        }));

        if (empty($newKeys)) {
            return $models;
        }

        $newIds    = array_intersect_key($idsMap, array_flip($newKeys));
        $newModels = $this->batchGetInternal($newIds);

        foreach ($newModels as $id => $model) {
            $key = $this->getAlbumKey($id);
            $this->cache->set($key, $model, $this->cacheExpires);
        }

        $models = ArrayHelper::merge($models, $newModels);

        return $models;
    }

    /**
     * @inheritdoc
     */
    public function batchGetInternal($ids)
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
    public function getPhotos($id, GetAlbumPhotosOptions $options = null)
    {
        $key = $this->getAlbumPhotosKey($id);

        if (($models = $this->cache->get($key)) === false) {
            $models = $this->getPhotosInternal($id, $options);
            $this->cache->set($key, $models, $this->cacheExpires);
        }

        return $models;
    }

    /**
     * @inheritdoc
     */
    public function getPhotosInternal($id, GetAlbumPhotosOptions $options = null)
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

        /** @var Album[] $models */
        $models = [];
        do {
            $response = $request->send();

            $collection = $this->yandexFotki->getFactory()->getAlbumsCollectionModel();
            $collection->loadWithData($response->getData(), true);

            $models  = ArrayHelper::merge($models, $collection->albums);
            $request = $httpClient->get($collection->linkNext);

        } while ($collection->linkNext);

        ksort($models);

        /** @var Album[][] $map */
        $map = ArrayHelper::index($models, 'id', function (Album $model) {
            return $model->parentId ?: '_root';
        });

        ksort($map);

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
     * @inheritdoc
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
     * @inheritdoc
     */
    public function update(UpdateAlbumOptions $options)
    {
        if (!$options->validate()) {
            throw new InvalidParamException(VarDumper::dumpAsString($options->getErrors()));
        }

        $httpClient = $this->yandexFotki->getApiHttpClient();
        $request    = $httpClient->put("album/{$options->id}/", $options->toArray());
        $response   = $request->send();

        $album = $this->yandexFotki->getFactory()->getAlbumModel();
        $album->loadWithData($response->getData(), true);

        return $album;
    }

    /**
     * @inheritdoc
     */
    public function batchUpdate(array $optionsArray)
    {
        $httpClient = $this->yandexFotki->getApiHttpClient();

        $requests = [];
        foreach ($optionsArray as $options) {
            if (!$options->validate()) {
                throw new InvalidParamException(VarDumper::dumpAsString($options->getErrors()));
            }

            $requests[] = $httpClient->put("album/{$options->id}/", $options->toArray());
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
     * @inheritdoc
     */
    public function delete(DeleteAlbumOptions $options)
    {
        if (!$options->validate()) {
            throw new InvalidParamException(VarDumper::dumpAsString($options->getErrors()));
        }

        if ($options->withPhotos == false) {
            $optionsModel = $this->getYandexFotki()->getFactory()->getGetAlbumPhotosOptions();
            $optionsModel->load([$optionsModel->formName() => ['password' => $options->password]]);

            if (count($this->getPhotos($options->id, $optionsModel))) {
                throw new DangerousDeleteOperationException();
            }
        }

        if ($options->withAlbums == false) {
            if (count($this->tree($options->id))) {
                throw new DangerousDeleteOperationException();
            }
        }

        $httpClient = $this->yandexFotki->getApiHttpClient();
        $request    = $httpClient->delete("album/{$options->id}/");
        $response   = $request->send();

        return $response->isOk;
    }

    /**
     * @inheritdoc
     */
    public function batchDelete(array $optionsArray)
    {
        $httpClient = $this->yandexFotki->getApiHttpClient();
        $requests   = [];
        foreach ($optionsArray as $options) {
            if (!$options->validate()) {
                throw new InvalidParamException(VarDumper::dumpAsString($options->getErrors()));
            }

            if ($options->withPhotos == false) {
                $optionsModel = $this->getYandexFotki()->getFactory()->getGetAlbumPhotosOptions();
                $optionsModel->load([$optionsModel->formName() => ['password' => $options->password]]);

                if (count($this->getPhotos($options->id, $optionsModel))) {
                    throw new DangerousDeleteOperationException();
                }
            }

            if ($options->withAlbums == false) {
                if (count($this->tree($options->id))) {
                    throw new DangerousDeleteOperationException();
                }
            }

            $requests[$options->id] = $httpClient->delete("album/{$options->id}/");
        }
        $responses = $httpClient->batchSend($requests);

        return ArrayHelper::getColumn($responses, 'isOk');
    }

    /**
     * @param int|string $id
     * @param string     $login
     *
     * @return string
     */
    public function getAlbumKey($id, $login = null)
    {
        return strtr($this->albumKeyPattern, [
            '{id}'    => $id,
            '{login}' => $login ?: $this->getYandexFotki()->getLogin()
        ]);
    }

    /**
     * @param int|string $id
     * @param string     $login
     *
     * @return string
     */
    public function getAlbumPhotosKey($id, $login = null)
    {
        return strtr($this->albumPhotosKeyPattern, [
            '{id}'    => $id,
            '{login}' => $login ?: $this->getYandexFotki()->getLogin()
        ]);
    }
}