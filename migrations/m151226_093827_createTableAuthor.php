<?php

use yii\db\Migration;

class m151226_093827_createTableAuthor extends Migration
{
    public function up()
    {
        $this->createTable('yandex__fotki__author', [
            'id'   => $this->primaryKey(),
            'uid'  => $this->bigInteger()->unique(),
            'name' => $this->string()->unique(),
        ]);
    }

    public function down()
    {
        $this->dropTable('yandex__fotki__author');
    }
}
