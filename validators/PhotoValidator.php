<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 26.02.2016
 * Time: 18:11
 */

namespace romkaChev\yandexFotki\validators;


use romkaChev\yandexFotki\interfaces\models\IPhoto;
use yii\validators\Validator;

/**
 * Class PhotoValidator
 *
 * @package romkaChev\yandexFotki\validators
 */
class PhotoValidator extends Validator
{
    /**
     * @inheritdoc
     */
    public function validateAttribute($model, $attribute)
    {
        if (!$model->{$attribute} instanceof IPhoto) {
            $instance = IPhoto::CLASS_NAME;
            $given    = get_class($this->$attribute);
            $this->addError($model, $attribute, "The point must be an instance of '{$instance}', '{$given}'");
        }
    }
}