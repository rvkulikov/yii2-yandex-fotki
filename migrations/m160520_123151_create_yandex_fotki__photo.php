<?php
use yii\db\Migration;

/**
 * Handles the creation for table `yandex_fotki__photo`.
 */
class m160520_123151_create_yandex_fotki__photo extends Migration
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

        $this->createTable('yandex_fotki__photo', [
            'id'                 => $this->primaryKey(),
            'authorId'           => $this->integer(),
            'albumId'            => $this->integer(),
            'accessId'           => $this->string(8)->notNull(),
            'ordinalPosition'    => $this->integer(),
            'title'              => $this->string(255),
            'summary'            => $this->string(8192),
            'isAdultsOnly'       => $this->boolean(),
            'isOriginalHidden'   => $this->boolean(),
            'isCommentsDisabled' => $this->boolean(),
            'publishedAt'        => $this->dateTime(),
            'latitude'           => $this->decimal(15, 12),
            'longitude'          => $this->decimal(15, 12),
            'updatedAt'          => $this->dateTime(),
            'editedAt'           => $this->dateTime(),
        ], $tableOptions);

        //@formatter:off
        $this->createIndex('authorId', 'yandex_fotki__photo', 'authorId');
        $this->createIndex('albumId',  'yandex_fotki__photo', 'albumId');
        $this->createIndex('accessId', 'yandex_fotki__photo', 'accessId');
        //@formatter:on

        $this->addForeignKey(
            'yandex_fotki__photo___authorId___yandex_fotki__author___id',
            'yandex_fotki__photo',
            'authorId',
            'yandex_fotki__author',
            'id'
        );

        $this->addForeignKey(
            'yandex_fotki__photo___albumId___yandex_fotki__album___id',
            'yandex_fotki__photo',
            'albumId',
            'yandex_fotki__album',
            'id'
        );

        $this->addForeignKey(
            'yandex_fotki__photo___albumId___yandex_fotki__photo_access___id',
            'yandex_fotki__photo',
            'accessId',
            'yandex_fotki__photo_access',
            'id'
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        //@formatter:off
        $this->dropForeignKey('yandex_fotki__photo___authorId___yandex_fotki__author___id',      'yandex_fotki__photo');
        $this->dropForeignKey('yandex_fotki__photo___albumId___yandex_fotki__album___id',        'yandex_fotki__photo');
        $this->dropForeignKey('yandex_fotki__photo___albumId___yandex_fotki__photo_access___id', 'yandex_fotki__photo');

        $this->dropIndex('authorId', 'yandex_fotki__photo');
        $this->dropIndex('albumId',  'yandex_fotki__photo');
        $this->dropIndex('accessId', 'yandex_fotki__photo');
        //@formatter:on

        $this->dropTable('yandex_fotki__photo');
    }
}
