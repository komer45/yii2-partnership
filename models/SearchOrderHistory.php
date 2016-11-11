<?php

namespace komer45\partnership\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use komer45\partnership\models\PsOrderHistory;

/**
 * SearchOrderHistory represents the model behind the search form about `komer45\partnership\models\PsOrderHistory`.
 */
class SearchOrderHistory extends PsOrderHistory
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['tmp_user_id', 'follow_id', 'date'], 'safe'],
            [['sum'], 'number'],
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
        $query = PsOrderHistory::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'sum' => $this->sum,
            'date' => $this->date,
        ]);

        $query->andFilterWhere(['like', 'tmp_user_id', $this->tmp_user_id])
            ->andFilterWhere(['like', 'follow_id', $this->follow_id]);

        return $dataProvider;
    }
}
