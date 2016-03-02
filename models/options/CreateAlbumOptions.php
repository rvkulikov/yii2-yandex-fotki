<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 27.02.2016
 * Time: 17:58
 */

namespace romkaChev\yandexFotki\models\options;

/**
 * Class CreateAlbumOptions
 *
 * @package romkaChev\yandexFotki\models\options
 */
class CreateAlbumOptions extends AbstractSaveAlbumOptions
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['title', 'string', 'min' => 1],
            ['title', 'required'],

            ['summary', 'string'],
            ['password', 'string'],
            ['parentId', 'integer'],
        ];
    }
}