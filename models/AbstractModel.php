<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 27.02.2016
 * Time: 19:42
 */

namespace romkaChev\yandexFotki\models;


use romkaChev\yandexFotki\interfaces\IYandexFotkiAccess;
use romkaChev\yandexFotki\traits\YandexFotkiAccess;
use yii\base\Model;

/**
 * Class AbstractModel
 *
 * @package romkaChev\yandexFotki\models
 */
abstract class AbstractModel extends Model implements IYandexFotkiAccess
{
    use YandexFotkiAccess;
}