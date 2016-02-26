<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 26.02.2016
 * Time: 21:19
 */

namespace romkaChev\yandexFotki\traits\parsers;


use romkaChev\yandexFotki\interfaces\models\IAddressBinding;
use yii\helpers\ArrayHelper;

/**
 * Class AddressBindingParser
 *
 * @package romkaChev\yandexFotki\traits\parsers
 */
trait AddressBindingParser
{
    /**
     * @param IAddressBinding $model
     *
     * @return \Closure
     */
    public function getAddressBindingParser(IAddressBinding $model)
    {
        /**
         * @param $array
         * @param $defaultValue
         *
         * @return IAddressBinding
         */
        return function ($array, $defaultValue) use ($model) {
            $value = clone $model;
            $value->loadWithData(ArrayHelper::getValue($array, 'addressBinding.0'));

            return $value ?: $defaultValue;
        };
    }
}