<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 02.03.2016
 * Time: 12:55
 */

namespace romkaChev\yandexFotki\models\options;


/**
 * Class UpdateAlbumOptions
 *
 * @package romkaChev\yandexFotki\models\options
 */
class UpdateAlbumOptions extends AbstractSaveAlbumOptions
{
    /** @var int */
    public $id;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['id', 'integer'],
            ['id', 'required'],

            ['title', 'string', 'min' => 1],
            ['summary', 'string'],
            ['password', 'string'],
            ['parentId', 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        $data = parent::toArray($fields, $expand, $recursive);

        unset($data['id']);

        return $data;
    }
}