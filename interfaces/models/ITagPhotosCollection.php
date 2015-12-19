<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 9:59
 */

namespace romkaChev\yandexFotki\interfaces\models;

use romkaChev\yandexFotki\interfaces\IYandexFotkiAccess;

/**
 * Interface ITagPhotosCollection
 *
 * @package romkaChev\yandexFotki\interfaces\models
 *
 * @property string   urn
 * @property integer  id
 * @property string   title
 * @property IPhoto[] photos
 *
 * @property string   updatedAt
 *
 * @property string   linkSelf
 * @property string   linkAlternate
 */
interface ITagPhotosCollection extends IYandexFotkiAccess
{

}