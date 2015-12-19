<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 18.12.2015
 * Time: 22:43
 */

namespace romkaChev\yandexFotki\models;


use romkaChev\yandexFotki\interfaces\models\IPhoto;
use romkaChev\yandexFotki\traits\YandexFotkiAccess;
use yii\base\Model;

class Photo extends Model implements IPhoto
{
    use YandexFotkiAccess;

}