<?php

namespace backend\modules\protege\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\protege\models\CompanyOffer;

/**
 * CompanyOfferSearch represents the model behind the search form of `backend\modules\protege\models\CompanyOffer`.
 */
class CompanyOfferSearch extends CompanyOffer
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'session_id', 'company_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = CompanyOffer::find()
        ->where(['session_id' => $this->session_id])
        ->orderBy('updated_at DESC');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'company_id' => $this->company_id,
        ]);

        return $dataProvider;
    }
}
