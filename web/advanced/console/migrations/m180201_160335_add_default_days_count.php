<?php

use yii\db\Migration;

class m180201_160335_add_default_days_count extends Migration
{

	public function init()
	{
		$this->db = 'db_mysql';
		parent::init();
	}

    public function safeUp()
    {
			$this->addColumn('user', 'show_days_count', $this->integer()." DEFAULT 7");
    }

    public function safeDown()
    {
        $this->dropColumn('user', 'show_days_count');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180201_160335_add_default_days_count cannot be reverted.\n";

        return false;
    }
    */
}
