<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 26.02.2016
 * Time: 21:11
 */

namespace romkaChev\yandexFotki\traits\parsers;


use romkaChev\yandexFotki\interfaces\models\AbstractAuthor;
use yii\helpers\ArrayHelper;

/**
 * Class AuthorParser
 *
 * @package romkaChev\yandexFotki\traits\parsers
 */
trait AuthorParser
{
    /**
     * @param string|\Closure|array $key
     * @param AbstractAuthor        $model
     * @param bool                  $fast
     *
     * @return \Closure
     */
    public function getAuthorParser($key, AbstractAuthor $model, $fast = false)
    {
        /**
         * @param $array
         * @param $defaultValue
         *
         * @return mixed
         */
        return function ($array, $defaultValue) use ($key, $model, $fast) {
            $data = ArrayHelper::getValue($array, $key);
            if ($data instanceof AbstractAuthor) {
                return $data;
            }

            $model = clone $model;
            $model->loadWithData($data, $fast);

            return $model ?: $defaultValue;
        };
    }
}