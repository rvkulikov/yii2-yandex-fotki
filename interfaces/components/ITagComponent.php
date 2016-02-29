<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 8:57
 */

namespace romkaChev\yandexFotki\interfaces\components;


use romkaChev\yandexFotki\interfaces\IYandexFotkiAccess;
use romkaChev\yandexFotki\models\options\GetTagPhotosOptions;
use romkaChev\yandexFotki\models\Photo;
use romkaChev\yandexFotki\models\Tag;

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
     * @return \romkaChev\yandexFotki\models\Tag
     */
    public function get($id);

    /**
     * @param int|string          $id
     * @param GetTagPhotosOptions $options
     *
     * @return Photo[]
     */
    public function getPhotos($id, GetTagPhotosOptions $options = null);
    
    /**
     * @param mixed $options
     *
     * @return Tag
     */
    public function update($options);

    /**
     * @param mixed $data
     *
     * @return \romkaChev\yandexFotki\models\Tag
     */
    public function delete($data);

    /**
     * @param $ids
     *
     * @return \romkaChev\yandexFotki\models\Tag[]
     */
    public function batchGet($ids);

    /**
     * @param $data
     *
     * @return Tag[]
     */
    public function batchUpdate($data);

    /**
     * @param $data
     *
     * @return \romkaChev\yandexFotki\models\Tag[]
     */
    public function batchDelete($data);
}