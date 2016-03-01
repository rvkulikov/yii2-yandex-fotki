<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 20.12.2015
 * Time: 8:29
 */

namespace romkaChev\yandexFotki\models;


use romkaChev\yandexFotki\interfaces\LoadableWithData;
use romkaChev\yandexFotki\traits\parsers\CoordinatesParser;
use yii\helpers\ArrayHelper;

/**
 * Class Point
 *
 * @package romkaChev\yandexFotki\models
 */
class Point extends AbstractModel implements LoadableWithData
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
     * @inheritdoc
     */
    public function loadWithData($data, $fast = false)
    {
        $attributes = [
            'zoomLevel'   => ArrayHelper::getValue($data, 'zoomlevel'),
            'type'        => ArrayHelper::getValue($data, 'type'),
            'mapType'     => ArrayHelper::getValue($data, 'maptype'),
            'coordinates' => ArrayHelper::getValue($data, $this->getCoordinatesParser('coordinates')),
        ];

        if ($fast) {
            \Yii::configure($this, $attributes);
        } else {
            $this->load([$this->formName() => $attributes]);
        }

        return $this;
    }
}