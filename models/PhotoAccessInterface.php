<?php
namespace romkaChev\yandexFotki\models;

/**
 * Interface PhotoAccessInterface
 *
 * @package romkaChev\yandexFotki\models
 *
 * @author  Roman Kulikov <flinnraider@yandex.ru>
 * @since   2.0
 */
interface PhotoAccessInterface
{
    const ACCESS_PUBLIC  = 'public';
    const ACCESS_FRIENDS = 'friends';
    const ACCESS_PRIVATE = 'private';
}