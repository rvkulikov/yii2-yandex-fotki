<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 8:57
 */

namespace romkaChev\yandexFotki\interfaces\components;


use romkaChev\yandexFotki\interfaces\IYandexFotkiAccess;
use romkaChev\yandexFotki\models\options\tag\DeleteTagOptions;
use romkaChev\yandexFotki\models\options\tag\GetTagPhotosOptions;
use romkaChev\yandexFotki\models\options\tag\UpdateTagOptions;
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
     * @return Tag
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
     * @param UpdateTagOptions $options
     *
     * @return Tag
     */
    public function update(UpdateTagOptions $options);

    /**
     * @param DeleteTagOptions $options
     *
     * @return boolean
     */
    public function delete(DeleteTagOptions $options);

    /**
     * @param $ids
     *
     * @return Tag[]
     */
    public function batchGet($ids);

    /**
     * @param UpdateTagOptions[] $optionsArray
     *
     * @return Tag[]
     */
    public function batchUpdate(array $optionsArray);

    /**
     * @param DeleteTagOptions[] $optionsArray
     *
     * @return boolean[]
     */
    public function batchDelete(array $optionsArray);
}