<?php

namespace komer45\partnership\models;

use Yii;

/**
 * This is the model class for table "ps_order_history".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $tmp_user_id
 * @property string $follow_id
 * @property string $sum
 * @property string $date
 */
class PsOrderHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_order_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['follow_id', 'sum', 'date'], 'required'],
            [['user_id', 'order_id', 'status', 'partner_id'], 'integer'],
            [['sum', 'recoil'], 'number'],
            [['date'], 'safe'],
            [['tmp_user_id', 'follow_id'], 'string', 'max' => 55],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'tmp_user_id' => 'Tmp User ID',
            'follow_id' => 'Follow ID',
            'sum' => 'Sum',
            'date' => 'Date',
			'order_id' => 'Order Id',
			'recoil' => 'Recoil',
			'status' => 'Status',
			'partner_id' => 'Partner Id',
        ];
    }
}
