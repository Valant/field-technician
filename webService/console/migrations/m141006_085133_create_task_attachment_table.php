<?php
/**
 * TODO: Migration description
 *
 * @package migrations
 */
class m141006_085133_create_task_attachment_table extends CDbMigration
{

	public function up() 
	{

		$this->execute("CREATE TABLE `task_attachment` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `task_id` int(11) unsigned NOT NULL,
  `path` varchar(400) NOT NULL DEFAULT '',
  `name` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `task_id` (`task_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

	}

	public function down() 
	{

		// TODO: Migration rollback actions

		echo "m141006_085133_create_task_attachment_table does not support migration down.\\n";
		return false;
	}

}

