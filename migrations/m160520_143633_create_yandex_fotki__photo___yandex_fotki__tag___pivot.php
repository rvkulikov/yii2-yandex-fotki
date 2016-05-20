<?php

use yii\db\Migration;

/**
 * Handles the creation for table `yandex_fotki__photo___yandex_fotki__tag___pivot`.
 */
class m160520_143633_create_yandex_fotki__photo___yandex_fotki__tag___pivot extends Migration
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

        $this->createTable('yandex_fotki__photo___yandex_fotki__tag___pivot', [
            'id'      => $this->primaryKey(),
            'photoId' => $this->integer(),
            'tagId'   => $this->string(64)->notNull(),
        ], $tableOptions);


        //@formatter:off
        $this->createIndex('photoId', 'yandex_fotki__photo___yandex_fotki__tag___pivot', 'photoId');
        $this->createIndex('tagId',   'yandex_fotki__photo___yandex_fotki__tag___pivot', 'tagId');
        //@formatter:on

        $this->addForeignKey(
            'yandex_fotki__photo___yandex_fotki__tag___pivot___photoId',
            'yandex_fotki__photo___yandex_fotki__tag___pivot',
            'photoId',
            'yandex_fotki__photo',
            'id'
        );

        $this->addForeignKey(
            'yandex_fotki__photo___yandex_fotki__tag___pivot___tagId',
            'yandex_fotki__photo___yandex_fotki__tag___pivot',
            'tagId',
            'yandex_fotki__tag',
            'id'
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        //@formatter:off
        $this->dropForeignKey('yandex_fotki__photo___yandex_fotki__tag___pivot___photoId', 'yandex_fotki__photo___yandex_fotki__tag___pivot');
        $this->dropForeignKey('yandex_fotki__photo___yandex_fotki__tag___pivot___tagId',   'yandex_fotki__photo___yandex_fotki__tag___pivot');

        $this->dropIndex('photoId', 'yandex_fotki__photo___yandex_fotki__tag___pivot');
        $this->dropIndex('tagId',   'yandex_fotki__photo___yandex_fotki__tag___pivot');
        //@formatter:on

        $this->dropTable('yandex_fotki__photo___yandex_fotki__tag___pivot');
    }
}
