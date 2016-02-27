<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 20.12.2015
 * Time: 10:06
 */

namespace romkaChev\yandexFotki\validators;


use romkaChev\yandexFotki\interfaces\models\AbstractImage;
use yii\validators\Validator;

class ImageValidator extends Validator
{
    /**
     * @inheritdoc
     */
    public function validateAttribute($model, $attribute)
    {
        if (!$this->$attribute instanceof AbstractImage) {
            $instance = AbstractImage::className();
            $given    = get_class($this->$attribute);
            $this->addError($model, $attribute, "{$attribute} must be an instance of '{$instance}', '{$given}' given.");
        }
    }

}