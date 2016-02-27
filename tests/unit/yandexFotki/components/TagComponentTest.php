<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 19.12.2015
 * Time: 16:11
 */

namespace romkaChev\yandexFotki\tests\unit\yandexFotki\components;


use romkaChev\yandexFotki\tests\unit\BaseTestCase;

class TagComponentTest extends BaseTestCase
{

    public function testGet()
    {
        $tagComponent = $this->getComponent()->getTags();
        $tag          = $tagComponent->get('common');
        $this->assertEquals('common', $tag->title);
    }

    public function testBatchGet()
    {
        $tagComponent = $this->getComponent()->getTags();
        $models       = $tagComponent->batchGet(['foo', 'bar']);

        $this->assertArrayHasKey('foo', $models);
        $this->assertArrayHasKey('bar', $models);
    }
}
