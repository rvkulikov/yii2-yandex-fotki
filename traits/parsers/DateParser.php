<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 26.02.2016
 * Time: 21:13
 */

namespace romkaChev\yandexFotki\traits\parsers;


use yii\helpers\ArrayHelper;

/**
 * Class DateParser
 *
 * @package romkaChev\yandexFotki\traits\parsers
 */
trait DateParser
{
    /**
     * @param string $key
     *
     * @return \Closure
     */
    public function getDateParser($key)
    {
        /**
         * @param $array
         * @param $defaultValue
         *
         * @return mixed
         */
        return function ($array, $defaultValue) use ($key) {
            return \Yii::$app->formatter->asDate(ArrayHelper::getValue($array, $key)) ?: $defaultValue;
        };
    }
}