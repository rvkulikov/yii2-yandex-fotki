<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 15:38
 */

define('YII_ENABLE_ERROR_HANDLER', true);
define('YII_DEBUG', true);

$_SERVER['SCRIPT_NAME']     = '/' . __DIR__;
$_SERVER['SCRIPT_FILENAME'] = __FILE__;

require_once(__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');
require_once(__DIR__ . '/../../vendor/autoload.php');

Yii::setAlias('@yiiunit', __DIR__);
Yii::setAlias('@demos', __DIR__ . '/../../demos');

require_once(__DIR__ . '/BaseTestCase.php');