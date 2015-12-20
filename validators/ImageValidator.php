<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 20.12.2015
 * Time: 10:06
 */

namespace romkaChev\yandexFotki\validators;


use romkaChev\yandexFotki\interfaces\models\IImage;
use yii\validators\Validator;

class ImageValidator extends Validator
{
    /**
     * @inheritdoc
     */
    public function validateAttribute($model, $attribute)
    {
        if (!$this->$attribute instanceof IImage) {
            $instance = IImage::CLASS_NAME;
            $given    = gettype($this->$attribute);
            $this->addError($model, $attribute, "The image must be an instance of {$instance}, {$given} given");
        }
    }

}