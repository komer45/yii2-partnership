<?php

use yii\db\Schema;
use yii\db\Migration;

class m161116_092612_create_table_merch extends Migration
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
             $this->createTable('{{%merch}}',[
               'id'=> $this->primaryKey(11),
               'name'=> $this->string(55)->notNull(),
               'price'=> $this->float()->null()->defaultValue(null),
               'comment'=> $this->text()->null()->defaultValue(null),
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
            $this->dropTable('{{%merch}}');
            $transaction->commit();
        } catch (Exception $e) {
            echo 'Catch Exception '.$e->getMessage().' and rollBack this';
            $transaction->rollBack();
        }
    }
}
