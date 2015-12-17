<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 15:38
 */

use romkaChev\yandexFotki\components\AlbumComponent;
use romkaChev\yandexFotki\components\PhotoComponent;
use romkaChev\yandexFotki\components\TagComponent;
use romkaChev\yandexFotki\Module;

return [
    'id'         => 'testApp',
    'basePath'   => __DIR__,
    'vendorPath' => __DIR__ . '/../../vendor',
    'aliases'    => [
        '@web'     => '/',
        '@webroot' => __DIR__ . '/runtime',
        '@vendor'  => __DIR__ . '/../../vendor',
    ],
    'modules'    => [
        'yandexFotki' => [
            'class'  => Module::className(),
            'albums' => AlbumComponent::className(),
            'photos' => PhotoComponent::className(),
            'tags'   => TagComponent::className(),
        ],
    ],
];