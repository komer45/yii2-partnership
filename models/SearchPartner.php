<?php

namespace komer45\partnership\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use komer45\partnership\models\PsPartner;

/**
 * SearchPartner represents the model behind the search form about `komer45\partnership\models\PsPartner`.
 */
class SearchPartner extends PsPartner
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'partner_id'], 'integer'],
            [['code'], 'safe'],
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
        $query = PsPartner::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'partner_id' => $this->partner_id,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code]);

        return $dataProvider;
    }
}
