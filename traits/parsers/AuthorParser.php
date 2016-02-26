<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 26.02.2016
 * Time: 21:11
 */

namespace romkaChev\yandexFotki\traits\parsers;


use romkaChev\yandexFotki\interfaces\IYandexFotki;
use romkaChev\yandexFotki\interfaces\models\IAuthor;
use yii\helpers\ArrayHelper;

/**
 * Class AuthorParser
 *
 * @package romkaChev\yandexFotki\traits\parsers
 *
 * @property IYandexFotki $yandexFotki
 */
trait AuthorParser
{
    /**
     * @param IAuthor $model
     *
     * @return \Closure
     */
    public function getAuthorParser(IAuthor $model)
    {
        /**
         * @param $array
         * @param $defaultValue
         *
         * @return mixed
         */
        return function ($array, $defaultValue) use ($model) {
            $model = clone $model;
            $model->loadWithData(ArrayHelper::getValue($array, 'authors.0'));

            return $model ?: $defaultValue;
        };
    }
}