<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 03.03.2016
 * Time: 16:25
 */

namespace romkaChev\yandexFotki\models\options\photo;


use romkaChev\yandexFotki\models\AbstractModel;

/**
 * Class DeletePhotoOptions
 *
 * @package romkaChev\yandexFotki\models\options\photo
 */
class DeletePhotoOptions extends AbstractModel
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
        ];
    }
}