<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 15:39
 */

namespace romkaChev\yandexFotki\components;


use romkaChev\yandexFotki\interfaces\components\IAlbumComponent;
use romkaChev\yandexFotki\interfaces\models\AbstractAlbum;
use romkaChev\yandexFotki\interfaces\models\AbstractPhoto;
use romkaChev\yandexFotki\interfaces\models\options\AbstractCreateAlbumOptions;
use romkaChev\yandexFotki\interfaces\models\options\AbstractGetAlbumPhotosOptions;
use romkaChev\yandexFotki\models\Album;
use romkaChev\yandexFotki\models\options\GetAlbumPhotosOptions;
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
     * @return Album
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
     * @param int|string                    $id
     * @param AbstractGetAlbumPhotosOptions $options
     *
     * @return AbstractPhoto[]
     */
    public function getPhotos($id, AbstractGetAlbumPhotosOptions $options = null)
    {
        if ($options === null) {
            $options = GetAlbumPhotosOptions::createDefault();
        }

        if (!$options->validate()) {
            throw new InvalidParamException(VarDumper::dumpAsString($options->getErrors()));
        }

        $photos = [];

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

            $photos  = ArrayHelper::merge($photos, $photosCollection->getPhotos());
            $request = $httpClient->get($photosCollection->linkNext);

        } while ($photosCollection->linkNext);

        return $photos;
    }

    /**
     * @param AbstractCreateAlbumOptions $options
     *
     * @return AbstractAlbum
     */
    public function create(AbstractCreateAlbumOptions $options)
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
     * @return AbstractAlbum
     */
    public function update($options)
    {
        // TODO: Implement update() method.
    }

    /**
     * @param mixed $data
     *
     * @return AbstractAlbum
     */
    public function delete($data)
    {
        // TODO: Implement delete() method.
    }

    /**
     * @param mixed $root
     *
     * @return mixed
     */
    public function tree($root)
    {
        // TODO: Implement tree() method.
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

        /** @var AbstractAlbum[] $models */
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
     * @return AbstractAlbum[]
     */
    public function batchUpdate($data)
    {
        // TODO: Implement multiUpdate() method.
    }

    /**
     * @param $data
     *
     * @return AbstractAlbum[]
     */
    public function batchDelete($data)
    {
        // TODO: Implement multiDelete() method.
    }
}