<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 28.02.2016
 * Time: 12:52
 */

namespace romkaChev\yandexFotki\interfaces\models;


interface IAccess
{
    const ACCESS_PUBLIC  = 'public';
    const ACCESS_FRIENDS = 'friends';
    const ACCESS_PRIVATE = 'private';
}