<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 10:30
 */

namespace romkaChev\yandexFotki\interfaces;

/**
 * Interface IModuleAccess
 *
 * @package romkaChev\yandexFotki\interfaces\components
 */
interface IModuleAccess
{
    /**
     * @return IModule
     */
    public function getModule();
}