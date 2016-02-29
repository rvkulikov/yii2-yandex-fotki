<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 26.02.2016
 * Time: 21:14
 */

namespace romkaChev\yandexFotki\traits\parsers;


use romkaChev\yandexFotki\models\Photo;
use yii\helpers\ArrayHelper;

/**
 * Class PhotosParser
 *
 * @package romkaChev\yandexFotki\traits\parsers
 */
trait PhotosParser
{
    /**
     * @param string|\Closure|array $key
     * @param Photo                 $model
     * @param bool                  $fast
     *
     * @return \Closure
     */
    public function getPhotosParser($key, Photo $model, $fast = false)
    {
        /**
         * @param $array
         *
         * @return \romkaChev\yandexFotki\models\Photo[]
         */
        return function ($array) use ($key, $model, $fast) {
            $entries = ArrayHelper::getValue($array, $key);
            $models  = [];

            foreach ($entries as $entry) {
                if ($entry instanceof Photo) {
                    $models[] = $entry;
                    continue;
                }

                $localModel = clone $model;
                $localModel->loadWithData($entry, $fast);

                $models[] = $localModel;
            }

            return ArrayHelper::index($models, 'id');
        };
    }
}