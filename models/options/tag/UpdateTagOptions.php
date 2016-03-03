<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 03.03.2016
 * Time: 17:16
 */

namespace romkaChev\yandexFotki\models\options\tag;


use romkaChev\yandexFotki\models\AbstractModel;

/**
 * Class UpdateTagOptions
 *
 * @package romkaChev\yandexFotki\models\options\tag
 */
class UpdateTagOptions extends AbstractModel
{
    /** @var string */
    public $id;
    /** @var string */
    public $title;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['id', 'string'],
            ['id', 'required'],

            ['title', 'string', 'min' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        $data = parent::toArray($fields, $expand, $recursive);

        unset($data['id']);

        $data = array_filter($data);

        return $data;
    }

}