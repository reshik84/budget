<?php

use yii\db\Migration;

class m170729_163857_add_colspan_rowspan extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%buget_detailes}}', 'colspan', $this->integer());
        $this->addColumn('{{%buget_detailes}}', 'rowspan', $this->integer());
    }

    public function safeDown()
    {
        echo "m170729_163857_add_colspan_rowspan cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170729_163857_add_colspan_rowspan cannot be reverted.\n";

        return false;
    }
    */
}
