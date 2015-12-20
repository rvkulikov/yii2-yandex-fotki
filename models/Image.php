<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 20.12.2015
 * Time: 9:47
 */

namespace romkaChev\yandexFotki\models;


use romkaChev\yandexFotki\interfaces\models\IImage;
use romkaChev\yandexFotki\traits\YandexFotkiAccess;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class Image extends Model implements IImage
{
    use YandexFotkiAccess;

    /** @var string */
    public $href;
    /** @var int */
    public $height;
    /** @var int */
    public $width;
    /** @var int */
    public $byteSize;
    /** @var string */
    public $size;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['href', 'url'],
            ['height', 'integer'],
            ['width', 'integer'],
            ['byteSize', 'integer'],
            ['size', 'string'],
        ];
    }


    /**
     * @param array $data
     *
     * @return $this
     */
    public function loadWithData($data)
    {
        $this->load([
            $this->formName() => [
                'href'     => ArrayHelper::getValue($data, 'href'),
                'height'   => ArrayHelper::getValue($data, 'height'),
                'width'    => ArrayHelper::getValue($data, 'width'),
                'byteSize' => ArrayHelper::getValue($data, 'bytesize'),
                'size'     => ArrayHelper::getValue($data, 'size'),
            ],
        ]);

        return $this;
    }
}