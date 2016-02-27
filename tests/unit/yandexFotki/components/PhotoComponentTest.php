<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 20.12.2015
 * Time: 9:32
 */

namespace romkaChev\yandexFotki\tests\unit\yandexFotki\components;


use romkaChev\yandexFotki\tests\unit\BaseTestCase;

class PhotoComponentTest extends BaseTestCase
{

    public function testGet()
    {
        $photoComponent = $this->getComponent()->getPhotos();
        $photo          = $photoComponent->get(1767663);
        $this->assertEquals(1767663, $photo->id);
    }

    public function testBatchGet()
    {
        $photoComponent = $this->getComponent()->getPhotos();
        $models         = $photoComponent->batchGet([1767664, 1845379]);

        $this->assertArrayHasKey(1767664, $models);
        $this->assertArrayHasKey(1845379, $models);
    }
}
