<?php

namespace komer45\partnership\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use komer45\partnership\models\PsFollow;

/**
 * SearchFollow represents the model behind the search form about `komer45\partnership\models\PsFollow`.
 */
class SearchFollow extends PsFollow
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'partner_id'], 'integer'],
            [['ip', 'tmp_user_id', 'url_to', 'url_from', 'date'], 'safe'],
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
        $query = PsFollow::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'partner_id' => $this->partner_id,
            'date' => $this->date,
        ]);

        $query->andFilterWhere(['like', 'ip', $this->ip])
            ->andFilterWhere(['like', 'tmp_user_id', $this->tmp_user_id])
            ->andFilterWhere(['like', 'url_to', $this->url_to])
            ->andFilterWhere(['like', 'url_from', $this->url_from]);

        return $dataProvider;
    }
}
