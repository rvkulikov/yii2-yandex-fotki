<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 10:04
 */

namespace romkaChev\yandexFotki\interfaces\models;

use romkaChev\yandexFotki\interfaces\IModuleAccess;
use romkaChev\yandexFotki\interfaces\models\serviceDocument\IAlbumsList;
use romkaChev\yandexFotki\interfaces\models\serviceDocument\IPhotosList;
use romkaChev\yandexFotki\interfaces\models\serviceDocument\ITagsList;

/**
 * Interface IServiceDocument
 *
 * @package romkaChev\yandexFotki\interfaces\models
 * @property string      title
 * @property IAlbumsList albumsList
 * @property IPhotosList photosList
 * @property ITagsList   tagsList
 */
interface IServiceDocument extends IModuleAccess
{

}