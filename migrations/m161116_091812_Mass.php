<?php

use yii\db\Schema;
use yii\db\Migration;

class m161116_091812_Mass extends Migration
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
             $this->createTable('{{%ps_follow}}',[
               'id'=> $this->primaryKey(11),
               'ip'=> $this->string(55)->notNull(),
               'user_id'=> $this->integer(11)->null()->defaultValue(null),
               'tmp_user_id'=> $this->string(55)->null()->defaultValue(null),
               'url_to'=> $this->string(55)->notNull(),
               'url_from'=> $this->string(55)->null()->defaultValue(null),
               'partner_id'=> $this->integer(11)->notNull(),
               'date'=> $this->date()->notNull(),
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
            $this->dropTable('{{%ps_follow}}');
            $transaction->commit();
        } catch (Exception $e) {
            echo 'Catch Exception '.$e->getMessage().' and rollBack this';
            $transaction->rollBack();
        }
    }
}
