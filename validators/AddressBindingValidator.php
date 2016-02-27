<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 20.12.2015
 * Time: 9:02
 */

namespace romkaChev\yandexFotki\validators;


use romkaChev\yandexFotki\interfaces\models\AbstractAddressBinding;
use yii\validators\Validator;

class AddressBindingValidator extends Validator
{

    /**
     * @inheritdoc
     */
    public function validateAttribute($model, $attribute)
    {
        if (!$this->$attribute instanceof AbstractAddressBinding) {
            $instance = AbstractAddressBinding::className();
            $given    = get_class($this->$attribute);
            $this->addError($model, $attribute, "{$attribute} must be an instance of '{$instance}', '{$given}' given.");
        }
    }
}