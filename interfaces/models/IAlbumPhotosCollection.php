<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 9:52
 */

namespace romkaChev\yandexFotki\interfaces\models;

use romkaChev\yandexFotki\interfaces\IYandexFotkiAccess;

/**
 * Interface IAlbumPhotosCollection
 *
 * @package romkaChev\yandexFotki\interfaces\models
 *
 * @property string   urn
 * @property integer  id
 * @property IAuthor  author
 * @property string   title
 * @property string   summary
 *
 * @property IPhoto[] photos
 *
 * @property string   updatedAt
 *
 * @property string   linkSelf
 * @property string   linkAlternate
 */
interface IAlbumPhotosCollection extends IYandexFotkiAccess
{

}