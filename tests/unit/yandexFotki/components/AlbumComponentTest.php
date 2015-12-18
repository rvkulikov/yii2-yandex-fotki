<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 16:47
 */

namespace romkaChev\yandexFotki\tests\unit\yandexFotki\components;


use romkaChev\yandexFotki\tests\unit\BaseTestCase;

/**
 * Class AlbumComponentTest
 *
 * @package romkaChev\yandexFotki\tests\unit\yandexFotki\components
 *
 * todo magic album ids
 */
class AlbumComponentTest extends BaseTestCase
{

    public function testGet()
    {
        $album = $this->getModule()->albums->get(487438);
        $this->assertEquals(487438, $album->id);
    }
}
