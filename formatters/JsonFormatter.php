<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 27.02.2016
 * Time: 23:11
 */

namespace romkaChev\yandexFotki\formatters;


use yii\helpers\Json;
use yii\httpclient\Request;

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