<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 26.02.2016
 * Time: 21:14
 */

namespace romkaChev\yandexFotki\traits\parsers;


use romkaChev\yandexFotki\interfaces\models\AbstractPhoto;
use yii\helpers\ArrayHelper;

/**
 * Class PhotosParser
 *
 * @package romkaChev\yandexFotki\traits\parsers
 */
trait PhotosParser
{
    /**
     * @param AbstractPhoto $model
     *
     * @return \Closure
     */
    public function getPhotosParser(AbstractPhoto $model)
    {
        /**
         * @param $array
         *
         * @return AbstractPhoto[]
         */
        return function ($array) use ($model) {
            $entries = ArrayHelper::getValue($array, 'entries');

            $photos = array_map(function ($entry) use ($model) {
                $localModel = clone $model;
                $localModel->loadWithData($entry);

                return $localModel;
            }, $entries);

            return ArrayHelper::index($photos, 'id');
        };
    }

}