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
            'title'     => $this->string(64)->notNull() . ' PRIMARY KEY',
            'updatedAt' => $this->dateTime(),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('yandex_fotki__tag');
    }
}
