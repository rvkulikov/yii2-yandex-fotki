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
use yii\base\InvalidConfigException;

/**
 * Class YandexFotkiAccess
 *
 * @package romkaChev\yandexFotki\traits
 */
trait YandexFotkiAccess
{

    /**
     * @var IYandexFotki
     */
    protected $yandexFotki;

    /**
     * @return IYandexFotki
     */
    public function getYandexFotki()
    {
        return $this->yandexFotki;
    }

    /**
     * @param IYandexFotki|string|array|callable $value
     *
     * @return $this
     * @throws InvalidConfigException
     */
    public function setYandexFotki($value)
    {
        $instance = '\romkaChev\yandexFotki\interfaces\IYandexFotki'; // todo hardcode

        if (!$value instanceof $instance) {
            $value = \Yii::createObject($value);
        }

        if (!$value instanceof $instance) {
            $given    = get_class($value);
            throw new InvalidArgumentException("Value must be an instance of '{$instance}', '{$given}' given.");
        }

        $this->yandexFotki = $value;

        return $this;
    }
}