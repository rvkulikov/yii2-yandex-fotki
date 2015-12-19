<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 9:19
 */

namespace romkaChev\yandexFotki\interfaces\models;

use romkaChev\yandexFotki\interfaces\IYandexFotkiAccess;

/**
 * Interface IAuthor
 *
 * @package romkaChev\yandexFotki\interfaces\models
 *
 * @property string  name
 * @property integer uid
 */
interface IAuthor extends IYandexFotkiAccess
{

    const CLASS_NAME = __CLASS__;

}