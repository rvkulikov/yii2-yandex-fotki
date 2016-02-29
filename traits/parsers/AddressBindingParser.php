<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 26.02.2016
 * Time: 21:19
 */

namespace romkaChev\yandexFotki\traits\parsers;


use romkaChev\yandexFotki\models\AddressBinding;
use yii\helpers\ArrayHelper;

/**
 * Class AddressBindingParser
 *
 * @package romkaChev\yandexFotki\traits\parsers
 */
trait AddressBindingParser
{
    /**
     * @param string|\Closure|array                        $key
     * @param \romkaChev\yandexFotki\models\AddressBinding $model
     * @param bool                                         $fast
     *
     * @return \Closure
     */
    public function getAddressBindingParser($key, AddressBinding $model, $fast = false)
    {
        /**
         * @param $array
         * @param $defaultValue
         *
         * @return AddressBinding
         */
        return function ($array, $defaultValue) use ($key, $model, $fast) {
            $data = ArrayHelper::getValue($array, $key);
            if ($data instanceof AddressBinding) {
                return $data;
            }

            $value = clone $model;
            $value->loadWithData($data, $fast);

            return $value ?: $defaultValue;
        };
    }
}