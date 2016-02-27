<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 20.12.2015
 * Time: 8:29
 */

namespace romkaChev\yandexFotki\interfaces\models;


use romkaChev\yandexFotki\traits\parsers\CoordinatesParser;
use yii\helpers\ArrayHelper;

/**
 * Class AbstractPoint
 *
 * @package romkaChev\yandexFotki\interfaces\models
 */
abstract class AbstractPoint extends AbstractModel
{
    use CoordinatesParser;

    /** @var int */
    public $zoomLevel;
    /** @var string */
    public $type;
    /** @var string */
    public $mapType;
    /** @var float[] */
    public $coordinates;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['zoomLevel', 'integer'],
            ['type', 'string'],
            ['mapType', 'string'],
            ['coordinates', 'each', 'rule' => ['number']],
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
            'zoomLevel'   => ArrayHelper::getValue($data, 'zoomlevel'),
            'type'        => ArrayHelper::getValue($data, 'type'),
            'mapType'     => ArrayHelper::getValue($data, 'maptype'),
            'coordinates' => ArrayHelper::getValue($data, $this->getCoordinatesParser()),
        ]);

        return $this;
    }
}