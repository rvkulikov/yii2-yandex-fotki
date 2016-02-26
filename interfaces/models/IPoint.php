<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 20.12.2015
 * Time: 8:29
 */

namespace romkaChev\yandexFotki\interfaces\models;


use romkaChev\yandexFotki\interfaces\IYandexFotkiAccess;

interface IPoint extends IYandexFotkiAccess
{
    const CLASS_NAME = __CLASS__;

    /**
     * @param array $data
     *
     * @return static
     */
    public function loadWithData($data);
}