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
 * Class DeleteTagOptions
 *
 * @package romkaChev\yandexFotki\models\options\tag
 */
class DeleteTagOptions extends AbstractModel
{
    /** @var int */
    public $id;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['id', 'string'],
            ['id', 'required'],
        ];
    }
}