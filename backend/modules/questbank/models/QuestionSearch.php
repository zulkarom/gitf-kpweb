<?php

namespace backend\modules\questbank\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\questbank\models\Question;

/**
 * QuestionSearch represents the model behind the search form of `backend\modules\questbank\models\Question`.
 */
class QuestionSearch extends Question
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'course_id', 'qtype_id', 'category_id', 'level'], 'integer'],
            [['qtext', 'qtext_bi', 'created_at', 'updated_at'], 'safe'],
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
            'course_id' => $this->course_id,
            'qtype_id' => $this->qtype_id,
            'category_id' => $this->category_id,
            'level' => $this->level,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'qtext', $this->qtext])
            ->andFilterWhere(['like', 'qtext_bi', $this->qtext_bi]);

        return $dataProvider;
    }
}
