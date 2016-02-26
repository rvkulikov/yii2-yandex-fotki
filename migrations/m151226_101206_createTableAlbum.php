<?php

use yii\db\Migration;

class m151226_101206_createTableAlbum extends Migration
{
    public function up()
    {
        $this->createTable('yandex__fotki__album', [
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
        $this->createIndex('authorId', 'yandex__fotki__album', 'authorId');
        $this->addForeignKey('yandex__fotki__album___fk_1', 'yandex__fotki__album', 'authorId', 'yandex__fotki__author', 'id');
        //@formatter:on
    }

    public function down()
    {
        //@formatter:off
        $this->dropForeignKey('yandex__fotki__album___fk_1', 'yandex__fotki__album');
        $this->dropIndex('authorId', 'yandex__fotki__tag');
        //@formatter:on

        $this->dropTable('yandex__fotki__album');
    }
}
