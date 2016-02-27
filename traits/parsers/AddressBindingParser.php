<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 26.02.2016
 * Time: 21:19
 */

namespace romkaChev\yandexFotki\traits\parsers;


use romkaChev\yandexFotki\interfaces\models\AbstractAddressBinding;
use yii\helpers\ArrayHelper;

/**
 * Class AddressBindingParser
 *
 * @package romkaChev\yandexFotki\traits\parsers
 */
trait AddressBindingParser
{
    /**
     * @param AbstractAddressBinding $model
     *
     * @return \Closure
     */
    public function getAddressBindingParser(AbstractAddressBinding $model)
    {
        /**
         * @param $array
         * @param $defaultValue
         *
         * @return AbstractAddressBinding
         */
        return function ($array, $defaultValue) use ($model) {
            $value = clone $model;
            $value->loadWithData(ArrayHelper::getValue($array, 'addressBinding.0'));

            return $value ?: $defaultValue;
        };
    }
}