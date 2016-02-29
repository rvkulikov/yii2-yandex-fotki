<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 9:56
 */

namespace romkaChev\yandexFotki\interfaces\models;

use romkaChev\yandexFotki\interfaces\IYandexFotkiAccess;
use romkaChev\yandexFotki\models\Author;
use romkaChev\yandexFotki\models\Tag;

/**
 * Interface ITagsCollection
 *
 * @package romkaChev\yandexFotki\interfaces\models
 *
 * @property string urn
 * @property string id
 * @property Author author
 * @property string title
 * @property Tag[]  tags
 *
 * @property string updatedAt
 *
 * @property string linkSelf
 * @property string linkAlternate
 */
interface ITagsCollection extends IYandexFotkiAccess
{

}