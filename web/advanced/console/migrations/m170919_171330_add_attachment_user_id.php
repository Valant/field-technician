<?php

use yii\db\Migration;

class m170919_171330_add_attachment_user_id extends Migration
{

    public function init()
    {
        $this->db = 'db_mysql';
        parent::init();
    }

    public function safeUp()
    {
        $this->addColumn('task_attachment','tech_id',$this->integer());
    }

    public function safeDown()
    {
        $this->dropColumn('task_attachment', 'tech_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m170919_171330_add_attachment_user_id cannot be reverted.\n";

        return false;
    }
    */
}
