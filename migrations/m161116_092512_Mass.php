<?php

use yii\db\Schema;
use yii\db\Migration;

class m161116_092512_Mass extends Migration
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
             $this->createTable('{{%ps_payment}}',[
               'id'=> $this->primaryKey(11),
               'sum'=> $this->decimal(11, 2)->null()->defaultValue(null),
               'date'=> $this->date()->null()->defaultValue(null),
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
            $this->dropTable('{{%ps_payment}}');
            $transaction->commit();
        } catch (Exception $e) {
            echo 'Catch Exception '.$e->getMessage().' and rollBack this';
            $transaction->rollBack();
        }
    }
}
