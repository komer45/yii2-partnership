<?php

namespace komer45\partnership\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use komer45\partnership\models\Setting as SettingModel;

/**
 * Setting represents the model behind the search form about `komer45\partnership\models\Setting`.
 */
class Setting extends SettingModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sum'], 'integer'],
            [['percent'], 'number'],
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
        $query = SettingModel::find();

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
