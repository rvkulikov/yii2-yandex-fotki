<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 27.02.2016
 * Time: 18:28
 */

namespace romkaChev\yandexFotki\models\options\album;

use romkaChev\yandexFotki\models\options\PaginationOptions;

/**
 * Class GetAlbumPhotosOptions
 *
 * @package romkaChev\yandexFotki\models\options\album
 */
class GetAlbumPhotosOptions extends PaginationOptions
{
    /** @var string */
    public $password;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(), [
            ['password', 'string']
        ]);
    }
}