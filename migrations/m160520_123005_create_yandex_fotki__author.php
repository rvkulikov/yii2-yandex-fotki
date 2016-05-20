<?php
use yii\db\Migration;

/**
 * Handles the creation for table `yandex_fotki__author`.
 */
class m160520_123005_create_yandex_fotki__author extends Migration
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

        $this->createTable('yandex_fotki__author', [
            'uid'  => $this->primaryKey(),
            'name' => $this->string(),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('yandex_fotki__author');
    }
}
