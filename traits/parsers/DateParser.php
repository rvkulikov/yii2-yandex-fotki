<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 26.02.2016
 * Time: 21:13
 */

namespace romkaChev\yandexFotki\traits\parsers;


use DateTime;
use DateTimeZone;
use yii\helpers\ArrayHelper;
use yii\i18n\Formatter;

/**
 * Class DateParser
 *
 * @package romkaChev\yandexFotki\traits\parsers
 */
trait DateParser
{
    /**
     * @param string|\Closure|array $key
     * @param Formatter             $formatter
     *
     * @return \Closure
     */
    public function getDateParser($key, $formatter)
    {
        /**
         * @param $array
         * @param $defaultValue
         *
         * @return mixed
         */
        return function ($array, $defaultValue) use ($key, $formatter) {
            $value = ArrayHelper::getValue($array, $key);

            return $value
                ? new DateTime($value, new DateTimeZone($formatter->timeZone))
                : $defaultValue;
        };
    }
}