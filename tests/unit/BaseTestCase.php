<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 15:43
 */

namespace romkaChev\yandexFotki\tests\unit;


use yii\console\Application;

class BaseTestCase extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        new Application(require(__DIR__ . '/config.php'));
    }
}