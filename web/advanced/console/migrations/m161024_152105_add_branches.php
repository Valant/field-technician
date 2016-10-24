<?php

    use yii\db\Migration;

    class m161024_152105_add_branches extends Migration
    {
        public function init()
        {
            $this->db = 'db_mysql';
            parent::init();
        }


        // Use safeUp/safeDown to run migration code within a transaction
        public function safeUp()
        {
            $this->createTable('branches', [
              'id'   => $this->primaryKey(11),
              'name' => $this->string('255')
            ]);

            $this->addColumn('user', 'branch_id', $this->integer(11));
            $this->addForeignKey('fk_user_branch', 'user', 'branch_id',
              'branches', 'id');
        }

        public function safeDown()
        {
            $this->dropForeignKey('fk_user_branch', 'user');
            $this->dropColumn('user', 'branch_id');
            $this->dropTable('branches');
        }

    }
