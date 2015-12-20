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
        $photo = $this->getComponent()->photos->get(1767663);
        $this->assertEquals(1767663, $photo->id);
    }
}
