<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 11:11
 */

namespace romkaChev\yandexFotki\traits;


use InvalidArgumentException;
use romkaChev\yandexFotki\interfaces\IYandexFotki;
use romkaChev\yandexFotki\YandexFotki;
use yii\base\InvalidConfigException;

/**
 * Class ModuleAccess
 *
 * @package romkaChev\yandexFotki\traits
 * @property YandexFotki yandexFotki
 */
trait YandexFotkiAccess
{

    /**
     * @var YandexFotki
     */
    private $_yandexFotki;

    /**
     * @return YandexFotki
     */
    public function getYandexFotki()
    {
        return $this->_yandexFotki;
    }

    /**
     * @param IYandexFotki|string|array|callable $value
     *
     * @return $this
     * @throws InvalidConfigException
     */
    public function setYandexFotki($value)
    {
        if (!$value instanceof IYandexFotki) {
            $value = \Yii::createObject($value);
        }

        if (!$value instanceof IYandexFotki) {
            $instance = IYandexFotki::CLASS_NAME;
            $given    = gettype($value);
            throw new InvalidArgumentException("Value must be an instance of '{$instance}', '{$given}' given.");
        }

        $this->_yandexFotki = $value;

        return $this;
    }
}