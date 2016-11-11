<?php

namespace komer45\partnership\models;

use Yii;

/**
 * This is the model class for table "ps_follow".
 *
 * @property integer $id
 * @property string $ip
 * @property integer $user_id
 * @property string $tmp_user_id
 * @property string $url_to
 * @property string $url_from
 * @property integer $partner_id
 * @property string $date
 */
class PsFollow extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ps_follow';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ip', 'url_to',  'partner_id', 'date'], 'required'],
            [['user_id', 'partner_id'], 'integer'],
            [['date'], 'safe'],
            [['ip', 'tmp_user_id', 'url_to', 'url_from'], 'string', 'max' => 55],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ip' => 'Ip',
            'user_id' => 'User ID',
            'tmp_user_id' => 'Tmp User ID',
            'url_to' => 'Url To',
            'url_from' => 'Url From',
            'partner_id' => 'Partner ID',
            'date' => 'Date',
        ];
    }
}
