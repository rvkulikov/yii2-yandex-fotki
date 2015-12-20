<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 20.12.2015
 * Time: 9:02
 */

namespace romkaChev\yandexFotki\validators;


use romkaChev\yandexFotki\interfaces\models\IPoint;
use yii\validators\Validator;

class PointValidator extends Validator
{

    /**
     * @inheritdoc
     */
    public function validateAttribute($model, $attribute)
    {
        if (!$this->$attribute instanceof IPoint) {
            $instance = IPoint::CLASS_NAME;
            $given    = gettype($this->$attribute);
            $this->addError($model, $attribute, "The point must be an instance of {$instance}, {$given} given");
        }
    }
}