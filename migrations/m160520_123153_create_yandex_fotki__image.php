<?php
use yii\db\Migration;

/**
 * Handles the creation for table `yandex_fotki__image`.
 */
class m160520_123153_create_yandex_fotki__image extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('yandex_fotki__image', [
            'id'       => $this->primaryKey(),
            'photoId'  => $this->integer(),
            'sizeId'   => $this->string(8)->notNull(),
            'width'    => $this->integer(),
            'height'   => $this->integer(),
            'byteSize' => $this->integer(),
            'href'     => $this->string(),
        ], $tableOptions);

        $this->createIndex('photoId', 'yandex_fotki__image', 'photoId');
        $this->createIndex('sizeId', 'yandex_fotki__image', 'sizeId');

        $this->addForeignKey(
            'yandex_fotki__image___photoId___yandex_fotki__photo___id',
            'yandex_fotki__image',
            'photoId',
            'yandex_fotki__photo',
            'id'
        );

        $this->addForeignKey(
            'yandex_fotki__image___sizeId___yandex_fotki__image_size___id',
            'yandex_fotki__image',
            'sizeId',
            'yandex_fotki__image_size',
            'id'
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        //@formatter:off
        $this->dropForeignKey('yandex_fotki__image___photoId___yandex_fotki__photo___id',     'yandex_fotki__image');
        $this->dropForeignKey('yandex_fotki__image___sizeId___yandex_fotki__image_size___id', 'yandex_fotki__image');
        
        $this->dropIndex('photoId', 'yandex_fotki__image');
        $this->dropIndex('sizeId',  'yandex_fotki__image');
        //@formatter:on

        $this->dropTable('yandex_fotki__image');
    }
}
