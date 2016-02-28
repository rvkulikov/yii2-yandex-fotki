<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 9:03
 */

namespace romkaChev\yandexFotki\interfaces\components;


use romkaChev\yandexFotki\interfaces\IYandexFotkiAccess;
use romkaChev\yandexFotki\interfaces\models\AbstractAlbum;
use romkaChev\yandexFotki\interfaces\models\AbstractPhoto;
use romkaChev\yandexFotki\interfaces\models\options\AbstractCreateAlbumOptions;
use romkaChev\yandexFotki\interfaces\models\options\AbstractGetAlbumPhotosOptions;
use romkaChev\yandexFotki\models\options\CreateAlbumOptions;

/**
 * Interface IAlbumComponent
 *
 * @package romkaChev\yandexFotki\interfaces\components
 */
interface IAlbumComponent extends IYandexFotkiAccess
{
    /**
     * @param int|string $id
     *
     * @return AbstractAlbum
     */
    public function get($id);

    /**
     * @param int|string                    $id
     * @param AbstractGetAlbumPhotosOptions $options
     *
     * @return AbstractPhoto[]
     */
    public function getPhotos($id, AbstractGetAlbumPhotosOptions $options = null);

    /**
     * @param AbstractCreateAlbumOptions $options
     *
     * @return AbstractAlbum
     */
    public function create(AbstractCreateAlbumOptions $options);

    /**
     * @param mixed $options
     *
     * @return AbstractAlbum
     */
    public function update($options);

    /**
     * @param mixed $data
     *
     * @return AbstractAlbum
     */
    public function delete($data);

    /**
     * @param mixed $root
     *
     * @return mixed
     */
    public function tree($root);

    /**
     * @param $ids
     *
     * @return AbstractAlbum[]
     */
    public function batchGet($ids);

    /**
     * @param CreateAlbumOptions[] $optionsArray
     *
     * @return AbstractAlbum[]
     */
    public function batchCreate(array $optionsArray);

    /**
     * @param $data
     *
     * @return AbstractAlbum[]
     */
    public function batchUpdate($data);

    /**
     * @param $data
     *
     * @return AbstractAlbum[]
     */
    public function batchDelete($data);

}