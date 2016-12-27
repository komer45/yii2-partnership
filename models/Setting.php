<?php

namespace komer45\partnership\models;

use Yii;

/**
 * This is the model class for table "ps_setting".
 *
 * @property integer $id
 * @property integer $sum
 * @property integer $percent
 */
class Setting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sum'], 'required'],
            [['sum'], 'integer'],
			[['percent'], 'double'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sum' => 'Сумма',
            'percent' => 'Процент',
        ];
    }
}
