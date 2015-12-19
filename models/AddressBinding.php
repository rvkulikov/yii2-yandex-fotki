<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 18.12.2015
 * Time: 22:42
 */

namespace romkaChev\yandexFotki\models;


use romkaChev\yandexFotki\interfaces\models\IAddressBinding;
use romkaChev\yandexFotki\traits\YandexFotkiAccess;
use yii\base\Model;

class AddressBinding extends Model implements IAddressBinding
{
    use YandexFotkiAccess;
}