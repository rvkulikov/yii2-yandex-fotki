<?php
use yii\db\Migration;

/**
 * Handles the creation for table `yandex_fotki__tag`.
 */
class m160520_123137_create_yandex_fotki__tag extends Migration
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

        $this->createTable('yandex_fotki__tag', [
            'id'       => $this->string(64)->notNull() . ' PRIMARY KEY',
            'authorId' => $this->integer(),
        ], $tableOptions);

        $this->createIndex('authorId', 'yandex_fotki__tag', 'authorId');

        $this->addForeignKey(
            'yandex_fotki__tag___authorId___yandex_fotki__author___id',
            'yandex_fotki__tag',
            'authorId',
            'yandex_fotki__author',
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
        $this->dropForeignKey('yandex_fotki__tag___authorId___yandex_fotki__author___id', 'yandex_fotki__tag');
        $this->dropIndex('authorId', 'yandex_fotki__tag');

        $this->dropTable('yandex_fotki__tag');
    }
}
