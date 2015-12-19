<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 9:02
 */

namespace romkaChev\yandexFotki\interfaces\models;

use romkaChev\yandexFotki\interfaces\IYandexFotkiAccess;

/**
 * Interface IPhoto
 *
 * @package romkaChev\yandexFotki\interfaces\models
 *
 * @property string          urn
 * @property integer         id
 * @property IAuthor         author
 * @property string          access
 * @property boolean         isForAdult
 * @property boolean         isHideOriginal
 * @property boolean         isDisableComments
 *
 * @property mixed           point // todo
 * @property IAddressBinding addressBinding
 *
 * @property string          createdAt
 * @property string          updatedAt
 * @property string          editedAt
 *
 * @property string          linkSelf
 * @property string          linkEdit
 * @property string          linkAlternate
 * @property string          linkEditMedia
 * @property string          linkAlbum
 */
interface IPhoto extends IYandexFotkiAccess
{

}