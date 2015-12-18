<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 11:11
 */

namespace romkaChev\yandexFotki\traits;


use romkaChev\yandexFotki\Module;

/**
 * Class ModuleAccess
 *
 * @package romkaChev\yandexFotki\traits
 * @property Module module
 */
trait ModuleAccess
{
    /**
     * @return Module
     */
    public static function getModule()
    {
        return Module::getInstance();
    }
}