<?php

use yii\db\Schema;
use yii\db\Migration;

class m161116_091912_Mass extends Migration
{

    public function init()
    {
        $this->db = 'db';
        parent::init();
    }

    public function safeUp()
    {
        $tableOptions = 'ENGINE=InnoDB';
        $transaction=$this->db->beginTransaction();
        try{
             $this->createTable('{{%ps_order_history}}',[
               'id'=> $this->primaryKey(11),
               'user_id'=> $this->integer(11)->null()->defaultValue(null),
               'tmp_user_id'=> $this->string(55)->null()->defaultValue(null),
               'follow_id'=> $this->string(55)->notNull(),
               'sum'=> $this->decimal(11, 2)->notNull(),
               'date'=> $this->date()->notNull(),
               'order_id'=> $this->integer(11)->null()->defaultValue(null),
               'recoil'=> $this->decimal(11, 2)->null()->defaultValue(null),
               'status'=> $this->text()->null()->defaultValue(null),
               'partner_id'=> $this->integer(11)->null()->defaultValue(null),
            ], $tableOptions);
            $transaction->commit();
        } catch (Exception $e) {
             echo 'Catch Exception '.$e->getMessage().' and rollBack this';
             $transaction->rollBack();
        }
    }

    public function safeDown()
    {
        $transaction=$this->db->beginTransaction();
        try{
            $this->dropTable('{{%ps_order_history}}');
            $transaction->commit();
        } catch (Exception $e) {
            echo 'Catch Exception '.$e->getMessage().' and rollBack this';
            $transaction->rollBack();
        }
    }
}
