<?php

use yii\db\Migration;

class m160805_114529_add_login_stats extends Migration
{
    public function init()
    {
        $this->db = 'db_mysql';
        parent::init();
    }

    public function up()
    {
        $this->createTable('login_stats',[
            'id'=>$this->primaryKey(),
            'user'=>$this->string(100),
            'type'=>$this->smallInteger(),
            'time'=>$this->timestamp()
        ]);
    }

    public function down()
    {
        $this->dropTable('login_stats');
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
