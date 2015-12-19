<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 10:30
 */

namespace romkaChev\yandexFotki\interfaces;

use yii\base\InvalidConfigException;

/**
 * Interface IYandexFotkiComponentAccess
 *
 * @package romkaChev\yandexFotki\interfaces
 */
interface IYandexFotkiAccess
{
    /**
     * @return IYandexFotki
     */
    public function getYandexFotki();

    /**
     * @param IYandexFotki|string|array|callable $value
     *
     * @return $this
     * @throws InvalidConfigException
     */
    public function setYandexFotki($value);
}