<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 26.02.2016
 * Time: 21:17
 */

namespace romkaChev\yandexFotki\traits\parsers;


use romkaChev\yandexFotki\models\Image;
use yii\helpers\ArrayHelper;

/**
 * Class ImagesParser
 *
 * @package romkaChev\yandexFotki\traits\parsers
 */
trait ImagesParser
{
    /**
     * @param string|\Closure|array $key
     * @param Image                 $model
     * @param bool                  $fast
     *
     * @return \Closure
     */
    public function getImagesParser($key, Image $model, $fast = false)
    {
        /**
         * @param $array
         *
         * @return \romkaChev\yandexFotki\models\Image[]
         */
        return function ($array) use ($key, $model, $fast) {
            $entries = ArrayHelper::getValue($array, $key, []);
            $models  = [];

            foreach ($entries as $size => $entry) {
                if ($entry instanceof Image) {
                    $models[] = $entry;
                    continue;
                }

                $entry['size'] = $size;

                $localModel = clone $model;
                $localModel->loadWithData($entry, $fast);

                $models[] = $localModel;
            }

            return ArrayHelper::index($models, 'size');
        };
    }
}