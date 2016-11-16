<?php

use yii\db\Schema;
use yii\db\Migration;

class m161116_092112_Mass extends Migration
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
             $this->createTable('{{%ps_partner}}',[
               'id'=> $this->primaryKey(11),
               'partner_id'=> $this->integer(11)->notNull(),
               'code'=> $this->string(55)->notNull(),
            ], $tableOptions);
            $this->createIndex('id','{{%ps_partner}}','id',false);
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
            $this->dropTable('{{%ps_partner}}');
            $transaction->commit();
        } catch (Exception $e) {
            echo 'Catch Exception '.$e->getMessage().' and rollBack this';
            $transaction->rollBack();
        }
    }
}
