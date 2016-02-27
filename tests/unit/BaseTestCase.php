<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 15:43
 */

namespace romkaChev\yandexFotki\tests\unit;


use romkaChev\yandexFotki\interfaces\IYandexFotki;
use yii\console\Application;
use yii\helpers\ArrayHelper;

class BaseTestCase extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        new Application(ArrayHelper::merge(
            require(__DIR__ . '/config/main.php'),
            require(__DIR__ . '/config/main-local.php')
        ));
    }

    /**
     * @return IYandexFotki
     */
    public function getComponent()
    {
        /** @noinspection PhpUndefinedFieldInspection */
        return \Yii::$app->yandexFotki;
    }
}