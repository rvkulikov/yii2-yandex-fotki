<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 8:59
 */

namespace romkaChev\yandexFotki\interfaces\components;


use romkaChev\yandexFotki\interfaces\IYandexFotkiAccess;
use romkaChev\yandexFotki\models\options\CreatePhotoOptions;
use romkaChev\yandexFotki\models\Photo;

/**
 * Interface IPhotoComponent
 *
 * @package romkaChev\yandexFotki\interfaces\components
 */
interface IPhotoComponent extends IYandexFotkiAccess
{
    /**
     * @param int|string $id
     *
     * @return Photo
     */
    public function get($id);

    /**
     * @param CreatePhotoOptions $options
     *
     * @return \romkaChev\yandexFotki\models\Photo
     */
    public function create(CreatePhotoOptions $options);

    /**
     * @param mixed $options
     *
     * @return Photo
     */
    public function update($options);

    /**
     * @param mixed $data
     *
     * @return \romkaChev\yandexFotki\models\Photo
     */
    public function delete($data);

    /**
     * @param $ids
     *
     * @return Photo[]
     */
    public function batchGet($ids);

    /**
     * @param \romkaChev\yandexFotki\models\options\CreatePhotoOptions[] $optionsArray
     *
     * @return Photo[]
     */
    public function batchCreate(array $optionsArray);

    /**
     * @param $data
     *
     * @return Photo[]
     */
    public function batchUpdate($data);

    /**
     * @param $data
     *
     * @return \romkaChev\yandexFotki\models\Photo[]
     */
    public function batchDelete($data);
}