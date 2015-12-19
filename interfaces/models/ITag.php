<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 8:50
 */

namespace romkaChev\yandexFotki\interfaces\models;

use romkaChev\yandexFotki\interfaces\IYandexFotkiAccess;

/**
 * Class ITag
 *
 * @package romkaChev\yandexFotki\interfaces\models
 * @see     https://tech.yandex.ru/fotki/doc/format-ref/atom-entry-tag-docpage/
 *
 * @property string  urn
 * @property string  $title
 * @property integer imageCount
 * @property IAuthor author
 *
 * @property string  updatedAt - alias for "updated" value
 *
 * @property string  linkSelf
 * @property string  linkEdit
 * @property string  linkPhotos
 * @property string  linkAlternate
 */
interface ITag extends IYandexFotkiAccess
{
}