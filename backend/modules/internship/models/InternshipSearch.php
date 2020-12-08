<?php

namespace backend\modules\internship\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\internship\models\InternshipList;

/**
 * InternshipSearch represents the model behind the search form of `backend\modules\internship\models\InternshipList`.
 */
class InternshipSearch extends InternshipList
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'matrik', 'nric', 'program', 'jilid', 'surat'], 'safe'],
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
        $query = InternshipList::find();

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'matrik', $this->matrik])
            ->andFilterWhere(['like', 'nric', $this->nric])
            ->andFilterWhere(['like', 'program', $this->program])
            ->andFilterWhere(['like', 'jilid', $this->jilid])
            ->andFilterWhere(['like', 'surat', $this->surat]);

        return $dataProvider;
    }
}
