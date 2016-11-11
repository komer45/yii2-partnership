<?php

namespace komer45\partnership\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use komer45\partnership\models\Merch;

/**
 * SearchMerch represents the model behind the search form about `common\models\merch\Merch`.
 */
class SearchMerch extends Merch
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'comment'], 'safe'],
            [['price'], 'number'],
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
        $query = Merch::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'price' => $this->price,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
