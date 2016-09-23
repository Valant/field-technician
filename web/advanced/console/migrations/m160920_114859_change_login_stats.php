<?php

use yii\db\Migration;

class m160920_114859_change_login_stats extends Migration
{

    public function init()
    {
        $this->db = 'db_mysql';
        parent::init();
    }


    public function safeUp()
    {
        $this->dropColumn('login_stats','time');
        $this->addColumn('login_stats', 'login_time', $this->timestamp());
        $this->addColumn('login_stats', 'logout_time', $this->timestamp()->null());
        $this->dropColumn('login_stats', 'type');
        $this->dropColumn('login_stats', 'user');
        $this->addColumn('login_stats','user_id', $this->integer(11));
    }

    public function safeDown()
    {
        $this->dropColumn('login_stats','logout_time');
        $this->renameColumn('login_stats','login_time', 'time');
        $this->addColumn('login_stats', 'type', $this->smallInteger());
        $this->dropColumn('login_stats', 'user_id');
        $this->addColumn('login_stats','user', $this->string(100));

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
