<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 29.02.2016
 * Time: 22:27
 */

namespace romkaChev\yandexFotki\traits\parsers;


use romkaChev\yandexFotki\models\Album;
use yii\helpers\ArrayHelper;

/**
 * Class AlbumsParser
 *
 * @package romkaChev\yandexFotki\traits\parsers
 */
trait AlbumsParser
{
    /**
     * @param string|\Closure|array $key
     * @param Album                 $model
     * @param bool                  $fast
     *
     * @return \Closure
     */
    public function getAlbumsParser($key, Album $model, $fast = false)
    {
        /**
         * @param $array
         *
         * @return \romkaChev\yandexFotki\models\Album[]
         */
        return function ($array) use ($key, $model, $fast) {
            $entries = ArrayHelper::getValue($array, $key);
            $models  = [];

            foreach ($entries as $entry) {
                if ($entry instanceof Album) {
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