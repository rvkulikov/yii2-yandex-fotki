<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 26.02.2016
 * Time: 21:21
 */

namespace romkaChev\yandexFotki\traits\parsers;


use yii\helpers\ArrayHelper;

/**
 * Class CoordinatesParser
 *
 * @package romkaChev\yandexFotki\traits\parsers
 */
trait CoordinatesParser
{
    /**
     * @return \Closure
     */
    public function getCoordinatesParser()
    {
        /**
         * @param $array
         * @param $defaultValue
         *
         * @return float[]|null
         */
        return function ($array, $defaultValue) {
            $coordinates = ArrayHelper::getValue($array, 'coordinates');

            return $coordinates ? array_map('floatval', explode(' ', $coordinates)) : $defaultValue;
        };
    }
}