<?php

namespace komer45\partnership\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use komer45\partnership\models\PsPayment;

/**
 * SearchPayment represents the model behind the search form about `common\modules\komer45\partnership\models\PsPayment`.
 */
class SearchPayment extends PsPayment
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'partner_id'], 'integer'],
            [['sum'], 'number'],
			[['date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = PsPayment::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'sum' => $this->sum,
			'date' => $this->date,
            'partner_id' => $this->partner_id,
        ]);

        return $dataProvider;
    }
}
