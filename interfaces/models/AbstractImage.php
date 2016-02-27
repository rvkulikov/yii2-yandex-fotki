<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 20.12.2015
 * Time: 9:47
 */

namespace romkaChev\yandexFotki\interfaces\models;


use yii\helpers\ArrayHelper;

/**
 * Class AbstractImage
 *
 * @package romkaChev\yandexFotki\interfaces\models
 */
abstract class AbstractImage extends AbstractModel implements IImageSize
{

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
        \Yii::configure($this, [
            'href'     => ArrayHelper::getValue($data, 'href'),
            'height'   => ArrayHelper::getValue($data, 'height'),
            'width'    => ArrayHelper::getValue($data, 'width'),
            'byteSize' => ArrayHelper::getValue($data, 'bytesize'),
            'size'     => ArrayHelper::getValue($data, 'size'),
        ]);

        return $this;
    }
}