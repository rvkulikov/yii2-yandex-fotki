<?php
namespace romkaChev\yandexFotki\formatters;

use yii\helpers\Json;
use yii\httpclient\Request;

/**
 * Class JsonFormatter
 *
 * @package romkaChev\yandexFotki\formatters
 *
 * @author  Roman Kulikov <flinnraider@yandex.ru>
 */
class JsonFormatter extends \yii\httpclient\JsonFormatter
{
    /**
     * @inheritdoc
     */
    public function format(Request $request)
    {
        $request->getHeaders()->set('Content-Type', 'application/json; type=entry');
        $request->setContent(Json::encode($request->getData(), $this->encodeOptions));

        return $request;
    }
}