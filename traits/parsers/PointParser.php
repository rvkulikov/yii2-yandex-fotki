<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 26.02.2016
 * Time: 21:12
 */

namespace romkaChev\yandexFotki\traits\parsers;


use romkaChev\yandexFotki\interfaces\models\IPoint;
use yii\helpers\ArrayHelper;

/**
 * Class PointParser
 *
 * @package romkaChev\yandexFotki\traits\parsers
 */
trait PointParser
{
    /**
     * @param IPoint $model
     *
     * @return \Closure
     */
    public function getPointParser(IPoint $model)
    {
        /**
         * @param $array
         * @param $defaultValue
         *
         * @return mixed
         */
        return function ($array, $defaultValue) use ($model) {
            $localModel = clone $model;
            $localModel->loadWithData(ArrayHelper::getValue($array, 'geo'));

            return $localModel ?: $defaultValue;
        };
    }
}