<?php

use yii\db\Schema;
use yii\db\Migration;

class m161116_091812_create_table_ps_follow extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';
             $this->createTable('{{%ps_follow}}',[
               'id'=> $this->primaryKey(11),
               'ip'=> $this->string(55)->notNull(),
               'user_id'=> $this->integer(11)->null()->defaultValue(null),
               'tmp_user_id'=> $this->string(55)->null()->defaultValue(null),
               'url_to'=> $this->string(55)->notNull(),
               'url_from'=> $this->string(55)->null()->defaultValue(null),
               'partner'=> $this->string(55)->notNull(),
               'date'=> $this->date()->notNull(),
			   'status'=> $this->integer(1)->notNull()->defaultValue('1'),
            ], $tableOptions);
    }

    public function safeDown()
    {

            $this->dropTable('{{%ps_follow}}');
            $transaction->commit();

    }
}
