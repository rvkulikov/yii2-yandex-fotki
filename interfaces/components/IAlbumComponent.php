<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 9:03
 */

namespace romkaChev\yandexFotki\interfaces\components;


use romkaChev\yandexFotki\interfaces\models\IAlbum;
use romkaChev\yandexFotki\interfaces\models\IPhoto;
use romkaChev\yandexFotki\models\options\GetAlbumPhotosOptions;

interface IAlbumComponent extends ICrudComponent
{

    const CLASS_NAME = __CLASS__;

    /**
     * @param int|string $id
     *
     * @return IAlbum
     */
    public function get($id);

    /**
     * @param int|string            $id
     * @param GetAlbumPhotosOptions $options
     *
     * @return IPhoto[]
     */
    public function getPhotos($id, GetAlbumPhotosOptions $options = null);

    /**
     * @param mixed $data
     *
     * @return IAlbum
     */
    public function create($data);

    /**
     * @param mixed $data
     *
     * @return IAlbum
     */
    public function update($data);

    /**
     * @param mixed $data
     *
     * @return IAlbum
     */
    public function delete($data);

    /**
     * @param mixed $root
     *
     * @return mixed
     */
    public function tree($root);

    /**
     * @param $identities
     *
     * @return IAlbum[]
     */
    public function batchGet($identities);

    /**
     * @param $data
     *
     * @return IAlbum[]
     */
    public function batchCreate($data);

    /**
     * @param $data
     *
     * @return IAlbum[]
     */
    public function batchUpdate($data);

    /**
     * @param $data
     *
     * @return IAlbum[]
     */
    public function batchDelete($data);

}