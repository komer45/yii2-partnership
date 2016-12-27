<?php

namespace komer45\partnership\models;

use Yii;

/**
 * This is the model class for table "_partner".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $code
 */
class Partner extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_partner';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'code'], 'required'],
            [['user_id', 'status'], 'integer'],
            [['code'], 'string', 'max' => 55],
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
            'code' => 'Code',
			'status' => 'Status',

        ];
    }
}
