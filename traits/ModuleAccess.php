<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 11:11
 */

namespace romkaChev\yandexFotki\traits;


use romkaChev\yandexFotki\interfaces\IModule;
use romkaChev\yandexFotki\Module;

/**
 * Class ModuleAccess
 *
 * @package romkaChev\yandexFotki\traits
 */
trait ModuleAccess
{
    /**
     * @return IModule
     */
    public function getModule()
    {
        return Module::getInstance();
    }
}