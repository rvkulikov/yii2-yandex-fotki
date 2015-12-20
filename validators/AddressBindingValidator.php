<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 20.12.2015
 * Time: 9:02
 */

namespace romkaChev\yandexFotki\validators;


use romkaChev\yandexFotki\interfaces\models\IAddressBinding;
use yii\validators\Validator;

class AddressBindingValidator extends Validator
{

    /**
     * @inheritdoc
     */
    public function validateAttribute($model, $attribute)
    {
        if (!$this->$attribute instanceof IAddressBinding) {
            $instance = IAddressBinding::CLASS_NAME;
            $given    = gettype($this->$attribute);
            $this->addError($model, $attribute,
                "The addressBinding must be an instance of {$instance}, {$given} given");
        }
    }
}