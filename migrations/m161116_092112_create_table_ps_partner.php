<?php

use yii\db\Schema;
use yii\db\Migration;

class m161116_092112_create_table_ps_partner extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

             $this->createTable('{{%ps_partner}}',[
               'id'=> $this->primaryKey(11),
               'user_id'=> $this->integer(11)->notNull(),
               'code'=> $this->string(55)->notNull(),
			   'status'=> $this->integer(1)->notNull()->defaultValue('0'),
            ], $tableOptions);
            $this->createIndex('id','{{%ps_partner}}','id',false);

    }

    public function safeDown()
    {

            $this->dropTable('{{%ps_partner}}');
            $transaction->commit();

    }
}
