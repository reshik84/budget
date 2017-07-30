<?php

use yii\db\Migration;

class m170729_172719_add_range extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%buget_detailes}}', 'range', $this->string());
    }

    public function safeDown()
    {
        echo "m170729_172719_add_range cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170729_172719_add_range cannot be reverted.\n";

        return false;
    }
    */
}
