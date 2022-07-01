<?php

namespace backend\modules\sae\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\sae\models\Question;

/**
 * QuestionSearch represents the model behind the search form of `backend\models\Question`.
 */
class QuestionSearch extends Question
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['que_id', 'display_cat', 'grade_cat'], 'integer'],
            [['que_text', 'que_text_bi'], 'safe'],
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
        $query = Question::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 150,
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
            'que_id' => $this->que_id,
            'display_cat' => $this->display_cat,
            'grade_cat' => $this->grade_cat,
        ]);

        $query->andFilterWhere(['like', 'que_text', $this->que_text])
            ->andFilterWhere(['like', 'que_text_bi', $this->que_text_bi]);

        return $dataProvider;
    }
}
