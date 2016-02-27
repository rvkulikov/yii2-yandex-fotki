<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 9:54
 */

namespace romkaChev\yandexFotki\interfaces\models;

use romkaChev\yandexFotki\interfaces\IYandexFotkiAccess;

/**
 * Interface IPhotosCollection
 *
 * @package romkaChev\yandexFotki\interfaces\models
 *
 * @property string          urn
 * @property integer         id
 * @property AbstractAuthor  author
 * @property string          title
 * @property AbstractPhoto[] photos
 *
 * @property string          updatedAt
 *
 * @property string          linkSelf
 * @property string          linkAlternate
 */
interface IPhotosCollection extends IYandexFotkiAccess
{

}