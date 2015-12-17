<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 9:50
 */

namespace romkaChev\yandexFotki\interfaces\models;

use romkaChev\yandexFotki\interfaces\IModuleAccess;

/**
 * Interface IAlbumsCollection
 *
 * @package romkaChev\yandexFotki\interfaces\models
 *
 * @property string   urn
 * @property IAuthor  author
 * @property string   title
 *
 * @property IAlbum[] albums
 *
 * @property string   updatedAt
 *
 * @property string   linkSelf
 * @property string   linkAlternate
 */
interface IAlbumsCollection extends IModuleAccess
{

}