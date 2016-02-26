<?php

use yii\db\Migration;

class m151226_095555_createTableTag extends Migration
{
    public function up()
    {
        $this->createTable('yandex__fotki__tag', [
            'id'            => $this->primaryKey(),
            'authorId'      => $this->integer(),
            'name'          => $this->string()->unique(),
            'linkSelf'      => $this->string()->unique(),
            'linkEdit'      => $this->string()->unique(),
            'linkPhotos'    => $this->string()->unique(),
            'linkAlternate' => $this->string()->unique(),
            'updatedAt'     => $this->dateTime(),
        ]);

        //@formatter:off
        $this->createIndex('authorId', 'yandex__fotki__tag', 'authorId');
        $this->addForeignKey('yandex__fotki__tag___fk_1', 'yandex__fotki__tag', 'authorId', 'yandex__fotki__author', 'id');
        //@formatter:on
    }

    public function down()
    {
        //@formatter:off
        $this->dropForeignKey('yandex__fotki__tag___fk_1', 'yandex__fotki__tag');
        $this->dropIndex('authorId', 'yandex__fotki__tag');
        //@formatter:on

        $this->dropTable('yandex__fotki__tag');
    }
}
