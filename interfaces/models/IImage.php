<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 20.12.2015
 * Time: 9:47
 */

namespace romkaChev\yandexFotki\interfaces\models;


use romkaChev\yandexFotki\interfaces\IYandexFotkiAccess;

interface IImage extends IYandexFotkiAccess, IImageSize
{
    const CLASS_NAME = __CLASS__;
}