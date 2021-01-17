<?php

namespace backend\modules\courseFiles\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\courseFiles\models\StudentLecture;

/**
 * StudentLectureSearch represents the model behind the search form of `backend\modules\courseFiles\models\StudentLecture`.
 */
class StudentLectureSearch extends StudentLecture
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'lecture_id', 'stud_check'], 'integer'],
            [['matric_no', 'assess_result'], 'safe'],
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
        $query = StudentLecture::find();

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
            'id' => $this->id,
            'lecture_id' => $this->lecture_id,
            'stud_check' => $this->stud_check,
        ]);

        $query->andFilterWhere(['like', 'matric_no', $this->matric_no])
            ->andFilterWhere(['like', 'assess_result', $this->assess_result]);

        return $dataProvider;
    }
}
