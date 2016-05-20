<?php
namespace romkaChev\yandexFotki;

use yii\base\InvalidConfigException;

/**
 * Class Module
 *
 * @package romkaChev\yandexFotki
 *
 * @author  Roman Kulikov <flinnraider@yandex.ru>
 * @since   2.0
 */
class Module extends \yii\base\Module
{
    public $login;
    public $oauthToken;

    /**
     * @throws InvalidConfigException
     */
    public function init()
    {
        parent::init();

        if (!$this->login) {
            throw new InvalidConfigException('"login" property must be set');
        }
        if (!$this->oauthToken) {
            throw new InvalidConfigException('"login" property must be set');
        }
    }
}