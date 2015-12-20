<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 20.12.2015
 * Time: 9:01
 */

namespace romkaChev\yandexFotki\validators;


use romkaChev\yandexFotki\interfaces\models\IAuthor;
use yii\validators\Validator;

class AuthorValidator extends Validator
{
    /**
     * @inheritdoc
     */
    public function validateAttribute($model, $attribute)
    {
        if (!$this->$attribute instanceof IAuthor) {
            $instance = IAuthor::CLASS_NAME;
            $given    = gettype($this->$attribute);
            $this->addError($model, $attribute, "The author must be an instance of {$instance}, {$given} given");
        }
    }
}