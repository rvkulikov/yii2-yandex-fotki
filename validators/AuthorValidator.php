<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 20.12.2015
 * Time: 9:01
 */

namespace romkaChev\yandexFotki\validators;


use romkaChev\yandexFotki\interfaces\models\AbstractAuthor;
use yii\validators\Validator;

class AuthorValidator extends Validator
{
    /**
     * @inheritdoc
     */
    public function validateAttribute($model, $attribute)
    {
        if (!$this->$attribute instanceof AbstractAuthor) {
            $instance = AbstractAuthor::className();
            $given    = get_class($this->$attribute);
            $this->addError($model, $attribute, "{$attribute} must be an instance of '{$instance}', '{$given}' given.");
        }
    }
}