<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 26.02.2016
 * Time: 18:11
 */

namespace romkaChev\yandexFotki\validators;


use romkaChev\yandexFotki\interfaces\models\AbstractPhoto;
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
        if (!$model->{$attribute} instanceof AbstractPhoto) {
            $instance = AbstractPhoto::className();
            $given    = get_class($this->$attribute);
            $this->addError($model, $attribute, "{$attribute} must be an instance of '{$instance}', '{$given}' given.");
        }
    }
}