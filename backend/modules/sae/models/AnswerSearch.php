<?php

namespace backend\modules\sae\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\sae\models\Answer;

/**
 * AnswerSearch represents the model behind the search form of `backend\models\Answer`.
 */
class AnswerSearch extends Answer
{
    public $others = null;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'bat_id', 'answer_status'], 'integer'],
            [['others', 'column1', 'column2', 'column3', 'column4'], 'string'],
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
        $query = Answer::find()
        ->alias('a')
        ->joinWith(['candidate c', 'batch b'])->orderBy('answer_status ASC');

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
            'a.overall_status' => $this->answer_status,
            'bat_id' => $this->bat_id,
        ]);


        $query->andFilterWhere(['or',
            ['like', 'c.username', $this->others],
            ['like', 'c.can_name', $this->others]
        ]);
            

        return $dataProvider;
    }
}
