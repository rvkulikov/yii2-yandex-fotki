<?php
namespace romkaChev\yandexFotki;

use romkaChev\yandexFotki\formatters\JsonFormatter;
use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\base\InvalidConfigException;
use yii\db\Connection;
use yii\httpclient\Client;
use yii\i18n\Formatter;

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

    /** @var Connection */
    public $db;
    /** @var Formatter */
    public $formatter;
    /** @var Client */
    public $httpClient;

    /** @var string */
    private $apiBaseUrl = 'http://api-fotki.yandex.ru/api';

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

        if (!$this->db) {
            $this->db = clone \Yii::$app->db;
        }
        if (!$this->db instanceof Connection) {
            $this->db = \Yii::createObject($this->db);
        }

        if (!$this->formatter) {
            $this->formatter = clone \Yii::$app->formatter;
        }
        if (!$this->formatter instanceof Formatter) {
            $this->formatter = \Yii::createObject($this->formatter);
        }

        if (!$this->httpClient) {
            $this->httpClient                 = \Yii::createObject(Client::className());
            $this->httpClient->baseUrl        = "{$this->apiBaseUrl}/users/{$this->login}";
            $this->httpClient->requestConfig  = [
                'headers' => [
                    'Accept'        => 'application/json',
                    'Authorization' => "OAuth {$this->oauthToken}",
                ],
                'format'  => Client::FORMAT_JSON,
            ];
            $this->httpClient->responseConfig = [
                'format' => Client::FORMAT_JSON,
            ];
            $this->httpClient->formatters     = [
                Client::FORMAT_JSON => JsonFormatter::className()
            ];
        }
        if (!$this->httpClient instanceof Client) {
            $this->httpClient = \Yii::createObject($this->httpClient);
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
            \Yii::setAlias('@romkaChev/yandexFotki/commands', __DIR__ . '/commands');
            $this->controllerNamespace = 'romkaChev\yandexFotki\commands';
        }
    }
}