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
     * @param string|\Closure|array $key
     *
     * @return \Closure
     */
    public function getCoordinatesParser($key)
    {
        /**
         * @param $array
         * @param $defaultValue
         *
         * @return float[]|null
         */
        return function ($array, $defaultValue) use ($key) {
            $coordinates = ArrayHelper::getValue($array, $key);

            return $coordinates ? array_map('floatval', explode(' ', $coordinates)) : $defaultValue;
        };
    }
}