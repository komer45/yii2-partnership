<?php

namespace komer45\partnership\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use komer45\partnership\models\Setting;

/**
 * SearchSetting represents the model behind the search form about `komer45\partnership\models\Setting`.
 */
class SearchSetting extends Setting
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sum', 'percent'], 'integer'],
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
        $query = Setting::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'sum' => $this->sum,
            'percent' => $this->percent,
        ]);

        return $dataProvider;
    }
}
