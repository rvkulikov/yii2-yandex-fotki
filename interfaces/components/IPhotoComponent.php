<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 8:59
 */

namespace romkaChev\yandexFotki\interfaces\components;


use romkaChev\yandexFotki\interfaces\models\IPhoto;

interface IPhotoComponent extends ICrudComponent
{

    const CLASS_NAME = __CLASS__;

    /**
     * @param int|string $id
     *
     * @return IPhoto
     */
    public function get($id);

    /**
     * @param mixed $data
     *
     * @return IPhoto
     */
    public function create($data);

    /**
     * @param mixed $data
     *
     * @return IPhoto
     */
    public function update($data);

    /**
     * @param mixed $data
     *
     * @return IPhoto
     */
    public function delete($data);

    /**
     * @param $ids
     *
     * @return IPhoto[]
     */
    public function batchGet($ids);

    /**
     * @param $data
     *
     * @return IPhoto[]
     */
    public function batchCreate($data);

    /**
     * @param $data
     *
     * @return IPhoto[]
     */
    public function batchUpdate($data);

    /**
     * @param $data
     *
     * @return IPhoto[]
     */
    public function batchDelete($data);
}