<?php
use yii\db\Migration;

/**
 * Handles the creation for table `yandex_fotki__image_size`.
 */
class m160520_123102_create_yandex_fotki__image_size extends Migration
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

        $this->createTable('yandex_fotki__image_size', [
            'id' => $this->string(8)->notNull() . ' PRIMARY KEY',
        ], $tableOptions);

        $this->batchInsert('yandex_fotki__image_size', ['id'], [
            'XXXS',
            'XXS',
            'XS',
            'S',
            'M',
            'L',
            'XL',
            'XXL',
            'XXXL',
            'X4L',
            'X5L',
            'orig',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('yandex_fotki__image_size');
    }
}
