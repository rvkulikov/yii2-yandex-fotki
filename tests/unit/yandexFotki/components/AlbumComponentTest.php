<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 17.12.2015
 * Time: 16:47
 */

namespace romkaChev\yandexFotki\tests\unit\yandexFotki\components;


use romkaChev\yandexFotki\models\options\CreateAlbumOptions;
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
        $albumComponent = $this->getComponent()->getAlbums();
        $model          = $albumComponent->get(487438);
        $this->assertEquals(487438, $model->id);
    }

    public function testGetPhotos()
    {
        $albumComponent = $this->getComponent()->getAlbums();
        $model          = $albumComponent->getPhotos(488819);

        $this->assertEquals(sort(array_keys($model)), sort(ArrayHelper::getColumn($model, 'id')));
    }

    public function testBatchGet()
    {
        $albumComponent = $this->getComponent()->getAlbums();
        $models         = $albumComponent->batchGet([487438, 488819]);

        $this->assertArrayHasKey(487438, $models);
        $this->assertArrayHasKey(488819, $models);
    }

    public function testCreate()
    {
        $factory        = $this->getComponent()->getFactory();
        $albumComponent = $this->getComponent()->getAlbums();

        /** @var CreateAlbumOptions $options */
        $options = \Yii::configure($factory->getCreateAlbumOptions(), [
            'title'   => 'testCreate1_title',
            'summary' => 'testCreate1_summary'
        ]);

        $model1 = $albumComponent->create($options);

        $this->assertEquals('testCreate1_title', $model1->title);
        $this->assertEquals('testCreate1_summary', $model1->summary);

        /** @var CreateAlbumOptions $options */
        $options = \Yii::configure($factory->getCreateAlbumOptions(), [
            'title'    => 'testCreate2_title',
            'summary'  => 'testCreate2_summary',
            'parentId' => $model1->id
        ]);

        $model2 = $albumComponent->create($options);

        $this->assertEquals('testCreate2_title', $model2->title);
        $this->assertEquals('testCreate2_summary', $model2->summary);
//        $this->assertEquals($model1->id, $model2->parentId); // todo

    }

    public function testBatchCreate()
    {
        $factory        = $this->getComponent()->getFactory();
        $albumComponent = $this->getComponent()->getAlbums();

        /** @var CreateAlbumOptions $options */
        $options1 = \Yii::configure($factory->getCreateAlbumOptions(), [
            'title'   => 'testBatchCreate1_title',
            'summary' => 'testBatchCreate1_summary'
        ]);

        /** @var CreateAlbumOptions $options */
        $options2 = \Yii::configure($factory->getCreateAlbumOptions(), [
            'title'   => 'testBatchCreate2_title',
            'summary' => 'testBatchCreate2_summary'
        ]);

        $models = $albumComponent->batchCreate([$options1, $options2]);

        $titles    = array_values(ArrayHelper::getColumn($models, 'title'));
        $summaries = array_values(ArrayHelper::getColumn($models, 'summary'));

        $this->assertArraySubset($titles, ['testBatchCreate1_title', 'testBatchCreate2_title']);
        $this->assertArraySubset($summaries, ['testBatchCreate1_summary', 'testBatchCreate2_summary']);
    }

    public function testTree()
    {
        $albumComponent = $this->getComponent()->getAlbums();
        $albumComponent->tree();
    }
}
