<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 9:03
 */

namespace romkaChev\yandexFotki\interfaces\components;


use romkaChev\yandexFotki\interfaces\IYandexFotkiAccess;
use romkaChev\yandexFotki\models\Album;
use romkaChev\yandexFotki\models\options\CreateAlbumOptions;
use romkaChev\yandexFotki\models\options\GetAlbumPhotosOptions;
use romkaChev\yandexFotki\models\options\GetAlbumsOptions;

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
     * @return Album
     */
    public function get($id);

    /**
     * @param int|string                                                  $id
     * @param \romkaChev\yandexFotki\models\options\GetAlbumPhotosOptions $options
     *
     * @return \romkaChev\yandexFotki\models\Photo[]
     */
    public function getPhotos($id, GetAlbumPhotosOptions $options = null);

    /**
     * @param CreateAlbumOptions $options
     *
     * @return Album
     */
    public function create(CreateAlbumOptions $options);

    /**
     * @param mixed $options
     *
     * @return Album
     */
    public function update($options);

    /**
     * @param mixed $data
     *
     * @return Album
     */
    public function delete($data);

    /**
     * @param int                                                    $id
     * @param \romkaChev\yandexFotki\models\options\GetAlbumsOptions $options
     *
     * @return Album[]
     */
    public function tree($id, GetAlbumsOptions $options = null);

    /**
     * @param $ids
     *
     * @return Album[]
     */
    public function batchGet($ids);

    /**
     * @param CreateAlbumOptions[] $optionsArray
     *
     * @return Album[]
     */
    public function batchCreate(array $optionsArray);

    /**
     * @param $data
     *
     * @return \romkaChev\yandexFotki\models\Album[]
     */
    public function batchUpdate($data);

    /**
     * @param $data
     *
     * @return Album[]
     */
    public function batchDelete($data);

}