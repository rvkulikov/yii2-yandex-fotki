<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 26.02.2016
 * Time: 21:17
 */

namespace romkaChev\yandexFotki\traits\parsers;


use romkaChev\yandexFotki\interfaces\IYandexFotki;
use romkaChev\yandexFotki\interfaces\models\IImage;
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
     * @param IImage $model
     *
     * @return \Closure
     */
    public function getImagesParser(IImage $model)
    {
        /**
         * @param $array
         *
         * @return IImage[]
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