<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 18.12.2015
 * Time: 22:43
 */

namespace romkaChev\yandexFotki\models;


use romkaChev\yandexFotki\interfaces\models\ITag;
use romkaChev\yandexFotki\traits\ModuleAccess;
use yii\base\Model;

class Tag extends Model implements ITag
{
    use ModuleAccess;
}