<?php
use yii\db\Migration;

/**
 * Handles the creation for table `yandex_fotki__album`.
 */
class m160520_123145_create_yandex_fotki__album extends Migration
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

        $this->createTable('yandex_fotki__album', [
            'id'          => $this->primaryKey(),
            'authorId'    => $this->integer(),
            'parentId'    => $this->integer(),
            'title'       => $this->string(255),
            'summary'     => $this->string(8192),
            'imageCount'  => $this->integer(),
            'publishedAt' => $this->dateTime(),
            'updatedAt'   => $this->dateTime(),
            'editedAt'    => $this->dateTime(),
        ], $tableOptions);

        $this->createIndex('authorId', 'yandex_fotki__album', 'authorId');
        $this->createIndex('parentId', 'yandex_fotki__album', 'parentId');

        $this->addForeignKey(
            'yandex_fotki__album___authorId___yandex_fotki__author___id',
            'yandex_fotki__album',
            'authorId',
            'yandex_fotki__author',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'yandex_fotki__album___parentId___yandex_fotki__album___id',
            'yandex_fotki__album',
            'parentId',
            'yandex_fotki__album',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropForeignKey('yandex_fotki__album___authorId___yandex_fotki__author___id', 'yandex_fotki__album');
        $this->dropForeignKey('yandex_fotki__album___parentId___yandex_fotki__album___id', 'yandex_fotki__album');

        $this->dropIndex('authorId', 'yandex_fotki__album');
        $this->dropIndex('parentId', 'yandex_fotki__album');

        $this->dropTable('yandex_fotki__album');
    }
}
