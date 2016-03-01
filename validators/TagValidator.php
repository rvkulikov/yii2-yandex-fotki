<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 01.03.2016
 * Time: 19:28
 */

namespace romkaChev\yandexFotki\validators;


use romkaChev\yandexFotki\interfaces\IYandexFotkiAccess;
use romkaChev\yandexFotki\models\Tag;
use romkaChev\yandexFotki\traits\YandexFotkiAccess;
use yii\validators\Validator;

/**
 * Class TagValidator
 *
 * @package romkaChev\yandexFotki\validators
 */
class TagValidator extends Validator implements IYandexFotkiAccess
{
    use YandexFotkiAccess;

    /**
     * @inheritdoc
     */
    public function validateAttribute($model, $attribute)
    {
        $instance = Tag::className();

        if (!$this->$attribute instanceof $instance) {
            $given = get_class($this->$attribute);
            $this->addError($model, $attribute, "{$attribute} must be an instance of '{$instance}', '{$given}' given.");
        }
    }
}