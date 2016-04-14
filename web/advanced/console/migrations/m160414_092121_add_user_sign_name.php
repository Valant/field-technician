<?php

use yii\db\Schema;
use yii\db\Migration;

class m160414_092121_add_user_sign_name extends Migration
{

    public function init()
    {
        $this->db = 'db_mysql';
        parent::init();
    }

    public function up()
    {
        $this->addColumn('task_attachment', 'sign_name','varchar(255)');
    }

    public function down()
    {
        $this->dropColumn('task_attachment', 'sign_name');
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
