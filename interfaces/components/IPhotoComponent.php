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
     * @param int|string|int[]|string[] $identity
     *
     * @return IPhoto
     */
    public function get($identity);

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
     * @param $identities
     *
     * @return IPhoto[]
     */
    public function multiGet($identities);

    /**
     * @param $data
     *
     * @return IPhoto[]
     */
    public function multiCreate($data);

    /**
     * @param $data
     *
     * @return IPhoto[]
     */
    public function multiUpdate($data);

    /**
     * @param $data
     *
     * @return IPhoto[]
     */
    public function multiDelete($data);
}