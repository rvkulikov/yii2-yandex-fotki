<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 9:03
 */

namespace romkaChev\yandexFotki\interfaces\components;


use romkaChev\yandexFotki\exceptions\DangerousDeleteOperationException;
use romkaChev\yandexFotki\interfaces\IYandexFotkiAccess;
use romkaChev\yandexFotki\models\Album;
use romkaChev\yandexFotki\models\options\CreateAlbumOptions;
use romkaChev\yandexFotki\models\options\DeleteAlbumOptions;
use romkaChev\yandexFotki\models\options\GetAlbumPhotosOptions;
use romkaChev\yandexFotki\models\options\GetAlbumsOptions;
use romkaChev\yandexFotki\models\options\UpdateAlbumOptions;

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
     * @param $ids
     *
     * @return Album[]
     */
    public function batchGet($ids);

    /**
     * @param int|string                                                  $id
     * @param \romkaChev\yandexFotki\models\options\GetAlbumPhotosOptions $options
     *
     * @return \romkaChev\yandexFotki\models\Photo[]
     */
    public function getPhotos($id, GetAlbumPhotosOptions $options = null);

    /**
     * @param int                                                    $id
     * @param \romkaChev\yandexFotki\models\options\GetAlbumsOptions $options
     *
     * @return Album[]
     */
    public function tree($id = null, GetAlbumsOptions $options = null);

    /**
     * @param CreateAlbumOptions $options
     *
     * @return Album
     */
    public function create(CreateAlbumOptions $options);

    /**
     * @param CreateAlbumOptions[] $optionsArray
     *
     * @return Album[]
     */
    public function batchCreate(array $optionsArray);

    /**
     * @param UpdateAlbumOptions $options
     *
     * @return Album
     */
    public function update(UpdateAlbumOptions $options);

    /**
     * @param UpdateAlbumOptions[] $optionsArray
     *
     * @return Album[]
     */
    public function batchUpdate(array $optionsArray);

    /**
     * @param DeleteAlbumOptions $options
     *
     * @return boolean
     * @throws DangerousDeleteOperationException // todo message
     */
    public function delete(DeleteAlbumOptions $options);

    /**
     * @param DeleteAlbumOptions[] $optionsArray
     *
     * @return boolean[]
     * @throws DangerousDeleteOperationException
     */
    public function batchDelete(array $optionsArray);
}