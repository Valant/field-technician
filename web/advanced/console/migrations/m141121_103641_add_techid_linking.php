<?php

    use yii\db\Schema;
    use yii\db\Migration;

    class m141121_103641_add_techid_linking extends Migration
    {

        public function init()
        {
            $this->db = 'db_mysql';
            parent::init();
        }

        public function up()
        {
            $this->addColumn( 'user', 'technition_id', 'int(11)' );

        }

        public function down()
        {
            $this->dropColumn( 'user', 'technition_id' );
        }
    }
