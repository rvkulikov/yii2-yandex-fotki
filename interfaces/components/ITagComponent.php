<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 8:57
 */

namespace romkaChev\yandexFotki\interfaces\components;


use romkaChev\yandexFotki\interfaces\IYandexFotkiAccess;
use romkaChev\yandexFotki\interfaces\models\AbstractPhoto;
use romkaChev\yandexFotki\interfaces\models\AbstractTag;
use romkaChev\yandexFotki\interfaces\models\options\AbstractGetTagPhotosOptions;

/**
 * Interface ITagComponent
 *
 * @package romkaChev\yandexFotki\interfaces\components
 */
interface ITagComponent extends IYandexFotkiAccess
{
    /**
     * @param string $id
     *
     * @return AbstractTag
     */
    public function get($id);

    /**
     * @param int|string                  $id
     * @param AbstractGetTagPhotosOptions $options
     *
     * @return AbstractPhoto[]
     */
    public function getPhotos($id, AbstractGetTagPhotosOptions $options = null);
    
    /**
     * @param mixed $options
     *
     * @return AbstractTag
     */
    public function update($options);

    /**
     * @param mixed $data
     *
     * @return AbstractTag
     */
    public function delete($data);

    /**
     * @param $ids
     *
     * @return AbstractTag[]
     */
    public function batchGet($ids);

    /**
     * @param $data
     *
     * @return AbstractTag[]
     */
    public function batchUpdate($data);

    /**
     * @param $data
     *
     * @return AbstractTag[]
     */
    public function batchDelete($data);
}