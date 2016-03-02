<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 8:59
 */

namespace romkaChev\yandexFotki\interfaces\components;


use romkaChev\yandexFotki\interfaces\IYandexFotkiAccess;
use romkaChev\yandexFotki\models\options\photo\CreatePhotoOptions;
use romkaChev\yandexFotki\models\Photo;

/**
 * Interface IPhotoComponent
 *
 * @package romkaChev\yandexFotki\interfaces\components
 */
interface IPhotoComponent extends IYandexFotkiAccess
{
    /**
     * todo password
     * 
     * @param int|string $id
     *
     * @return Photo
     */
    public function get($id);

    /**
     * @param \romkaChev\yandexFotki\models\options\photo\CreatePhotoOptions $options
     *
     * @return Photo
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
     * @return Photo
     */
    public function delete($data);

    /**
     * @param $ids
     *
     * @return Photo[]
     */
    public function batchGet($ids);

    /**
     * @param CreatePhotoOptions[] $optionsArray
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
     * @return Photo[]
     */
    public function batchDelete($data);
}