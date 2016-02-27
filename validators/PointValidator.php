<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 20.12.2015
 * Time: 9:02
 */

namespace romkaChev\yandexFotki\validators;


use romkaChev\yandexFotki\interfaces\models\AbstractPoint;
use yii\validators\Validator;

class PointValidator extends Validator
{

    /**
     * @inheritdoc
     */
    public function validateAttribute($model, $attribute)
    {
        if (!$this->$attribute instanceof AbstractPoint) {
            $instance = AbstractPoint::className();
            $given    = get_class($this->$attribute);
            $this->addError($model, $attribute, "{$attribute} must be an instance of '{$instance}', '{$given}' given.");
        }
    }
}