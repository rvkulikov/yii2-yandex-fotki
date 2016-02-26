<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 9:07
 */

namespace romkaChev\yandexFotki\interfaces\components;


use romkaChev\yandexFotki\interfaces\IYandexFotkiAccess;

interface ICrudComponent extends IYandexFotkiAccess
{
    /**
     * @param mixed $id
     *
     * @return mixed
     */
    public function get($id);

    /**
     * @param mixed $data
     *
     * @return mixed
     */
    public function create($data);

    /**
     * @param mixed $data
     *
     * @return mixed
     */
    public function update($data);

    /**
     * @param mixed $data
     *
     * @return mixed
     */
    public function delete($data);

    /**
     * @param $ids
     *
     * @return mixed
     */
    public function batchGet($ids);

    /**
     * @param $data
     *
     * @return mixed
     */
    public function batchCreate($data);

    /**
     * @param $data
     *
     * @return mixed
     */
    public function batchUpdate($data);

    /**
     * @param $data
     *
     * @return mixed
     */
    public function batchDelete($data);
}