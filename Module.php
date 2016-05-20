<?php
namespace romkaChev\yandexFotki;

use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\base\InvalidConfigException;

/**
 * Class Module
 *
 * @package romkaChev\yandexFotki
 *
 * @author  Roman Kulikov <flinnraider@yandex.ru>
 * @since   2.0
 */
class Module extends \yii\base\Module implements BootstrapInterface
{
    /** @var string */
    public $login;
    /** @var string */
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

    /**
     * Bootstrap method to be called during application bootstrap stage.
     *
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        /** @noinspection PhpUnnecessaryFullyQualifiedNameInspection */
        if ($app instanceof \yii\console\Application) {
            $this->controllerNamespace = 'romkaChev\yandexFotki\commands';
        }
    }
}