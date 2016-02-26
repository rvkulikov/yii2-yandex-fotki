<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 16:47
 */

namespace romkaChev\yandexFotki\tests\unit\yandexFotki\components;


use romkaChev\yandexFotki\tests\unit\BaseTestCase;
use yii\helpers\ArrayHelper;

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
        $albumComponent = $this->getComponent()->albums;
        $album          = $albumComponent->get(487438);
        $this->assertEquals(487438, $album->id);
    }

    public function testGetPhotos()
    {
        $albumComponent = $this->getComponent()->albums;
        $photos         = $albumComponent->getPhotos(488819);

        $this->assertEquals(sort(array_keys($photos)), sort(ArrayHelper::getColumn($photos, 'id')));
    }

    public function testBatchGet()
    {
        $albumComponent = $this->getComponent()->albums;
        $models         = $albumComponent->batchGet([487438, 488819]);

        $this->assertArrayHasKey(487438, $models);
        $this->assertArrayHasKey(488819, $models);
    }
}
