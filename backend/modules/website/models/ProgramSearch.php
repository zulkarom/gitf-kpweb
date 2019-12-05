<?php

namespace backend\modules\website\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\website\models\Program;

/**
 * ProgramSearch represents the model behind the search form of `backend\modules\website\models\Program`.
 */
class ProgramSearch extends Program
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'program_id'], 'integer'],
            [['summary', 'career'], 'safe'],
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
        $query = Program::find();

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
            'id' => $this->id,
            'program_id' => $this->program_id,
        ]);

        $query->andFilterWhere(['like', 'summary', $this->summary])
            ->andFilterWhere(['like', 'career', $this->career]);

        return $dataProvider;
    }
}
