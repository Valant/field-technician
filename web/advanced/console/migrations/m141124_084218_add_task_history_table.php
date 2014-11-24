<?php

use yii\db\Schema;
use yii\db\Migration;

class m141124_084218_add_task_history_table extends Migration
{
    public function init()
    {
        $this->db = 'db_mysql';
        parent::init();
    }

    public function up()
    {
        $this->execute("CREATE TABLE `task_history` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `task_id` int(11) unsigned NOT NULL,
  `tech_id` int(11) unsigned NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    }

    public function down()
    {
       $this->dropTable('task_history');
    }
}
