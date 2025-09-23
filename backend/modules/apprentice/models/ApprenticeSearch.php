<?php

namespace backend\modules\apprentice\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\apprentice\models\Apprentice;

/**
 * ApprenticeSearch represents the model behind the search form of `backend\modules\apprentice\models\Apprentice`.
 */
class ApprenticeSearch extends Apprentice
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'student_id', 'semester_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['program_code', 'course_code'], 'safe'],
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
        $query = Apprentice::find();

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
            'student_id' => $this->student_id,
            'semester_id' => $this->semester_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'program_code', $this->program_code])
            ->andFilterWhere(['like', 'course_code', $this->course_code]);

        return $dataProvider;
    }
}
