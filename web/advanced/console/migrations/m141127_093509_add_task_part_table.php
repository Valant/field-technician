<?php

use yii\db\Schema;
use yii\db\Migration;

class m141127_093509_add_task_part_table extends Migration
{
    public function init()
    {
        $this->db = 'db_mysql';
        parent::init();
    }

    public function up()
    {
        $this->execute("CREATE TABLE `task_part` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tech_id` int(11) unsigned NOT NULL,
  `task_id` int(11) unsigned NOT NULL,
  `part_id` varchar(255) NOT NULL DEFAULT '',
  `count` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `task_part` (`task_id`,`part_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    }

    public function down()
    {
        $this->dropTable('task_part');
    }
}
