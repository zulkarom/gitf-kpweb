<?php

namespace frontend\models;

use backend\modules\protege\models\CompanyOffer;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ProjectSearch represents the model behind the search form of `backend\modules\proceedings\models\Paper`.
 */
class ProtegeSearch extends CompanyOffer
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['session_id'], 'integer'],
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

        ->where(['session_id' => $this->session_id, 'is_published' => 1]);


        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
                'pageSize' => 100,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }


        /* $query->andFilterWhere(['like', 'paper_title', $this->paper_title])
            ->andFilterWhere(['like', 'author', $this->author])
            ->andFilterWhere(['like', 'paper_page', $this->paper_page])
            ->andFilterWhere(['like', 'paper_file', $this->paper_file]); */

        return $dataProvider;
    }
}
