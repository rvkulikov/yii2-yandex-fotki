<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 15:39
 */

namespace romkaChev\yandexFotki\components;


use romkaChev\yandexFotki\interfaces\components\IAlbumComponent;
use romkaChev\yandexFotki\interfaces\models\IAlbum;
use romkaChev\yandexFotki\interfaces\models\IPhoto;
use romkaChev\yandexFotki\models\Album;
use romkaChev\yandexFotki\models\options\GetAlbumPhotosOptions;
use romkaChev\yandexFotki\traits\YandexFotkiAccess;
use yii\base\Component;
use yii\base\InvalidParamException;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

class AlbumComponent extends Component implements IAlbumComponent
{

    use YandexFotkiAccess;

    /**
     * @param int|string $id
     *
     * @return Album
     */
    public function get($id)
    {
        $httpClient = $this->yandexFotki->httpClient;
        $request    = $httpClient->get("album/{$id}/", ['format' => 'json']);
        $response   = $request->send();

        $album = $this->yandexFotki->getAlbumModel();
        $album->loadWithData($response->getData());

        return $album;
    }

    /**
     * @param int|string            $id
     * @param GetAlbumPhotosOptions $options
     *
     * @return IPhoto[]
     */
    public function getPhotos($id, GetAlbumPhotosOptions $options = null)
    {
        if ($options === null) {
            $options = GetAlbumPhotosOptions::createDefault();
        }

        if (!$options->validate()) {
            throw new InvalidParamException(VarDumper::dumpAsString($options->getErrors()));
        }

        $photos = [];

        $httpClient = $this->yandexFotki->httpClient;
        $request    = $httpClient->get("album/{$id}/photos/{$options->sort}/", [
            'format'   => 'json',
            'limit'    => $options->limit,
            'password' => $options->password
        ]);

        do {
            $response = $request->send();

            $photosCollection = $this->yandexFotki->getAlbumPhotosCollectionModel();
            $photosCollection->loadWithData($response->getData());

            $photos  = ArrayHelper::merge($photos, $photosCollection->getPhotos());
            $request = $httpClient->get($photosCollection->linkNext);

        } while ($photosCollection->linkNext);

        return $photos;
    }

    /**
     * @param mixed $data
     *
     * @return IAlbum
     */
    public function create($data)
    {
        // TODO: Implement create() method.
    }

    /**
     * @param mixed $data
     *
     * @return IAlbum
     */
    public function update($data)
    {
        // TODO: Implement update() method.
    }

    /**
     * @param mixed $data
     *
     * @return IAlbum
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
     * @param $identities
     *
     * @return IAlbum[]
     */
    public function batchGet($identities)
    {
        // TODO: Implement multiGet() method.
    }

    /**
     * @param $data
     *
     * @return IAlbum[]
     */
    public function batchCreate($data)
    {
        // TODO: Implement multiCreate() method.
    }

    /**
     * @param $data
     *
     * @return IAlbum[]
     */
    public function batchUpdate($data)
    {
        // TODO: Implement multiUpdate() method.
    }

    /**
     * @param $data
     *
     * @return IAlbum[]
     */
    public function batchDelete($data)
    {
        // TODO: Implement multiDelete() method.
    }
}