<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 29.02.2016
 * Time: 21:07
 */

namespace romkaChev\yandexFotki\formatters;


use yii\base\Object;
use yii\httpclient\ParserInterface;
use yii\httpclient\Response;

class PlainParser extends Object implements ParserInterface
{
    /**
     * @inheritdoc
     */
    public function parse(Response $response)
    {
        return $response->getContent();
    }
}