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
use romkaChev\yandexFotki\Factory;
use romkaChev\yandexFotki\models\AddressBinding;
use romkaChev\yandexFotki\models\Album;
use romkaChev\yandexFotki\models\AlbumPhotosCollection;
use romkaChev\yandexFotki\models\Author;
use romkaChev\yandexFotki\models\Image;
use romkaChev\yandexFotki\models\options\CreateAlbumOptions;
use romkaChev\yandexFotki\models\options\GetAlbumPhotosOptions;
use romkaChev\yandexFotki\models\Photo;
use romkaChev\yandexFotki\models\Point;
use romkaChev\yandexFotki\models\Tag;
use romkaChev\yandexFotki\validators\AddressBindingValidator;
use romkaChev\yandexFotki\validators\AuthorValidator;
use romkaChev\yandexFotki\validators\ImageValidator;
use romkaChev\yandexFotki\validators\PhotoValidator;
use romkaChev\yandexFotki\validators\PointValidator;
use romkaChev\yandexFotki\YandexFotki;
use yii\httpclient\Client;

return [
    'id'         => 'testApp',
    'basePath'   => __DIR__,
    'vendorPath' => __DIR__ . '/../../../vendor',
    'aliases'    => [
        '@web'     => '/',
        '@webroot' => __DIR__ . '/../runtime',
        '@vendor'  => __DIR__ . '/../../../vendor',
    ],
    'components' => [
        'yandexFotki' => [
            //@formatter:off
            'class'      => YandexFotki::className(),

            'login'      => null, // set it in main-local.php
            'oauthToken' => null, // set it in main-local.php

            'httpClient' => Client::className(),

            'albums'     => AlbumComponent::className(),
            'photos'     => PhotoComponent::className(),
            'tags'       =>   TagComponent::className(),

            'factory'    => [
                'class'                      => Factory::className(),

                'addressBindingModel'        =>        AddressBinding::className(),
                'albumModel'                 =>                 Album::className(),
                'albumPhotosCollectionModel' => AlbumPhotosCollection::className(),
                'authorModel'                =>                Author::className(),
                'photoModel'                 =>                 Photo::className(),
                'tagModel'                   =>                   Tag::className(),
                'pointModel'                 =>                 Point::className(),
                'imageModel'                 =>                 Image::className(),

                'createAlbumOptions'         =>    CreateAlbumOptions::className(),
                'getAlbumPhotosOptions'      => GetAlbumPhotosOptions::className(),

                'addressBindingValidator'    => AddressBindingValidator::className(),
                'authorValidator'            =>         AuthorValidator::className(),
                'pointValidator'             =>          PointValidator::className(),
                'photoValidator'             =>          PhotoValidator::className(),
                'imageValidator'             =>          ImageValidator::className(),
            ],
            //@formatter:on
        ],
    ],
];