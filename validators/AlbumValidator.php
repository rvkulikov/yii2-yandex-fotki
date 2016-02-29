<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 29.02.2016
 * Time: 20:38
 */

namespace romkaChev\yandexFotki\validators;


use romkaChev\yandexFotki\interfaces\IYandexFotkiAccess;
use romkaChev\yandexFotki\models\Album;
use romkaChev\yandexFotki\traits\YandexFotkiAccess;
use yii\validators\Validator;

/**
 * Class AlbumValidator
 *
 * @package romkaChev\yandexFotki\validators
 */
class AlbumValidator extends Validator implements IYandexFotkiAccess
{
    use YandexFotkiAccess;

    /**
     * @inheritdoc
     */
    public function validateAttribute($model, $attribute)
    {
        $instance = Album::className();

        if (!$this->$attribute instanceof $instance) {
            $given = get_class($this->$attribute);
            $this->addError($model, $attribute, "{$attribute} must be an instance of '{$instance}', '{$given}' given.");
        }
    }
}