<?php

use yii\db\Migration;

class m170729_043753_init extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%buget}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer()
        ]);

        $this->createTable('{{%buget_detailes}}', [
            'id' => $this->primaryKey(),
            'buget_id' => $this->integer(),
            'col' => $this->string(4),
            'row' => $this->integer(),
            'value' => $this->string(),
            'fill' => $this->string(),
            'color' => $this->string()
        ]);

    }

    public function safeDown()
    {
        $this->dropTable('{{%buget}}');
        $this->dropTable('{{%buget_detailes}}');
    }

}
