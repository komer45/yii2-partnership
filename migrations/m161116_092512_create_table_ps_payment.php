<?php

use yii\db\Schema;
use yii\db\Migration;

class m161116_092512_create_table_ps_payment extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';

             $this->createTable('{{%ps_payment}}',[
               'id'=> $this->primaryKey(11),
               'sum'=> $this->decimal(11, 2)->null()->defaultValue(null),
               'date'=> $this->date()->null()->defaultValue(null),
               'partner_id'=> $this->integer(11)->null()->defaultValue(null),
			   'status'=> $this->string(1)->notNull()->defaultValue('0'),
            ], $tableOptions);

    }

    public function safeDown()
    {

            $this->dropTable('{{%ps_payment}}');
            $transaction->commit();

    }
}
