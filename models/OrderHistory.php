<?php

namespace komer45\partnership\models;

use Yii;

/**
 * This is the model class for table "_order_history".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $tmp_user_id
 * @property string $follow_id
 * @property string $sum
 * @property string $date
 */
class OrderHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	 
	 
	public $username; 
	 
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
            [['user_id', 'order_id', 'partner_id'], 'integer'],
            [['sum', 'recoil'], 'number'],
            [['date'], 'safe'],
            [['tmp_user_id', 'follow_id', 'status'], 'string', 'max' => 55],
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
            'follow_id' => 'Id ссылки',
            'sum' => 'Сумма заказа',
            'date' => 'Дата',
			'order_id' => 'Id заказа',
			'recoil' => 'Сумма вознаграждения',
			'status' => 'Статус',
			'partner_id' => 'Id партнера',
        ];
    }
	
	public function getUser()
    {
        $userModel = Yii::$app->user->identity;
        return $this->hasOne($userModel::className(), ['id' => 'user_id']);
    }
	
	public function getOrder()
    {
        return $this->hasOne(\pistol88\order\models\Order::className(), ['id' => 'order_id']);
    }
}
