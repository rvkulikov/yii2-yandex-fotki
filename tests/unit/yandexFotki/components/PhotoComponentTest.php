<?php
/**
 * Created by PhpStorm.
 * User: Roman
 * Date: 20.12.2015
 * Time: 9:32
 */

namespace romkaChev\yandexFotki\tests\unit\yandexFotki\components;


use romkaChev\yandexFotki\models\options\photo\CreatePhotoOptions;
use romkaChev\yandexFotki\tests\unit\BaseTestCase;
use yii\helpers\ArrayHelper;

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

    public function testCreate()
    {
        $factory        = $this->getComponent()->getFactory();
        $photoComponent = $this->getComponent()->getPhotos();

        /** @var CreatePhotoOptions $options */
        $options = \Yii::configure($factory->getCreatePhotoOptions(), [
            'image' => __DIR__ . '/../../assets/test.png',
            'tags'  => ['TEST_CREATE_1', 'TEST_CREATE_2']
        ]);

        $model = $photoComponent->create($options);

        $this->assertEquals('test.png', $model->title);

        $tags = array_values(ArrayHelper::getColumn($model->getTags(), 'title'));
        sort($tags);

        $this->assertArraySubset($tags, ['test_create_1', 'test_create_2']);
    }

    public function testBatchCreate()
    {
        $factory        = $this->getComponent()->getFactory();
        $photoComponent = $this->getComponent()->getPhotos();

        /** @var CreatePhotoOptions $options */
        $options1 = \Yii::configure($factory->getCreatePhotoOptions(), [
            'image'   => __DIR__ . '/../../assets/test.png',
            'title'   => 'testBatchCreate1_title',
            'summary' => 'testBatchCreate1_summary',
        ]);

        /** @var CreatePhotoOptions $options */
        $options2 = \Yii::configure($factory->getCreatePhotoOptions(), [
            'image'   => __DIR__ . '/../../assets/test.png',
            'title'   => 'testBatchCreate2_title',
            'summary' => 'testBatchCreate2_summary',
        ]);

        $models = $photoComponent->batchCreate([$options1, $options2]);

        $titles    = array_values(ArrayHelper::getColumn($models, 'title'));
        $summaries = array_values(ArrayHelper::getColumn($models, 'summary'));

        $this->assertArraySubset($titles, ['testBatchCreate1_title', 'testBatchCreate2_title']);
        $this->assertArraySubset($summaries, ['testBatchCreate1_summary', 'testBatchCreate2_summary']);
    }
}
