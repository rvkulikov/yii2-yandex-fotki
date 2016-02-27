<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 26.02.2016
 * Time: 21:17
 */

namespace romkaChev\yandexFotki\traits\parsers;


use romkaChev\yandexFotki\interfaces\IYandexFotki;
use romkaChev\yandexFotki\interfaces\models\AbstractImage;
use yii\helpers\ArrayHelper;

/**
 * Class ImagesParser
 *
 * @package romkaChev\yandexFotki\traits\parsers
 * @property IYandexFotki $yandexFotki
 */
trait ImagesParser
{
    /**
     * @param AbstractImage $model
     *
     * @return \Closure
     */
    public function getImagesParser(AbstractImage $model)
    {
        /**
         * @param $array
         *
         * @return AbstractImage[]
         */
        return function ($array) use ($model) {
            $images = [];
            foreach (ArrayHelper::getValue($array, 'img', []) as $size => $imageData) {
                $imageData['size'] = $size;

                $localModel = clone $model;
                $localModel->loadWithData($imageData);

                $images[] = $localModel;
            }

            return ArrayHelper::index($images, 'size');
        };
    }
}