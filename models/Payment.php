<?php

namespace komer45\partnership\models;

use Yii;

/**
 * This is the model class for table "ps_payment".
 *
 * @property integer $id
 * @property string $sum
 * @property integer $partner_id
 * @property integer $order_id
 */
class Payment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_payment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sum'], 'number'],
			[['date'],'safe'],
            [['partner_id', 'status'], 'integer'],
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
            'partner_id' => 'Id партнера',
            'date' => 'Дата',
        ];
    }
}
