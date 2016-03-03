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
use romkaChev\yandexFotki\models\options\photo\DeletePhotoOptions;
use romkaChev\yandexFotki\models\options\photo\UpdatePhotoOptions;
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
     * @param UpdatePhotoOptions $options
     *
     * @return Photo
     */
    public function update(UpdatePhotoOptions $options);

    /**
     * @param DeletePhotoOptions $options
     *
     * @return boolean
     */
    public function delete(DeletePhotoOptions $options);

    /**
     * todo password
     * 
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
     * @param UpdatePhotoOptions[] $optionsArray
     *
     * @return Photo[]
     */
    public function batchUpdate(array $optionsArray);

    /**
     * @param DeletePhotoOptions[] $optionsArray
     *
     * @return boolean[]
     */
    public function batchDelete(array $optionsArray);
}