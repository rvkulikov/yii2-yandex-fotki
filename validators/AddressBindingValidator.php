<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 20.12.2015
 * Time: 9:02
 */

namespace romkaChev\yandexFotki\validators;


use romkaChev\yandexFotki\interfaces\IYandexFotkiAccess;
use romkaChev\yandexFotki\interfaces\models\AbstractAddressBinding;
use romkaChev\yandexFotki\traits\YandexFotkiAccess;
use yii\validators\Validator;

/**
 * Class AddressBindingValidator
 *
 * @package romkaChev\yandexFotki\validators
 */
class AddressBindingValidator extends Validator implements IYandexFotkiAccess
{

    use YandexFotkiAccess;

    /**
     * @inheritdoc
     */
    public function validateAttribute($model, $attribute)
    {
        $instance = AbstractAddressBinding::className();

        if (!$this->$attribute instanceof $instance) {
            $given    = get_class($this->$attribute);
            $this->addError($model, $attribute, "{$attribute} must be an instance of '{$instance}', '{$given}' given.");
        }
    }
}