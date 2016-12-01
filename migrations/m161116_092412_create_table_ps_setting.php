<?php

use yii\db\Schema;
use yii\db\Migration;

class m161116_092412_create_table_ps_setting extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

             $this->createTable('{{%ps_setting}}',[
               'id'=> $this->primaryKey(11),
               'sum'=> $this->integer(11)->notNull(),
               'percent'=> $this->double()->null()->defaultValue(null),
            ], $tableOptions);

    }

    public function safeDown()
    {

            $this->dropTable('{{%ps_setting}}');
            $transaction->commit();

    }
}
