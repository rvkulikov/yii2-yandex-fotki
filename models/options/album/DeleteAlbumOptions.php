<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 02.03.2016
 * Time: 13:06
 */

namespace romkaChev\yandexFotki\models\options\album;


use romkaChev\yandexFotki\models\AbstractModel;

/**
 * Class DeleteAlbumOptions
 *
 * @package romkaChev\yandexFotki\models\options\album
 */
class DeleteAlbumOptions extends AbstractModel
{
    /** @var int */
    public $id;
    /** @var boolean */
    public $withPhotos;
    /** @var boolean */
    public $withAlbums;
    /** @var string */
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['id', 'integer'],
            ['id', 'required'],

            ['withPhotos', 'boolean'],
            ['withAlbums', 'boolean'],

            ['withPhotos', 'default', 'value' => false],
            ['withAlbums', 'default', 'value' => false],

            ['password', 'string'],
        ];
    }
}