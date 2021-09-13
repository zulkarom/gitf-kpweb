<?php

namespace backend\modules\postgrad\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\postgrad\models\StudentPostGrad;

/**
 * StudentPostGradSearch represents the model behind the search form of `backend\modules\postgrad\models\StudentPostGrad`.
 */
class StudentPostGradSearch extends StudentPostGrad
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'gender', 'marital_status', 'nationality', 'citizenship', 'edu_level', 'student_email', 'religion', 'race', 'session', 'sponsor', 'student_current_sem', 'city_campus', 'student_status'], 'integer'],
            [['matric_no', 'name', 'nric', 'date_birth', 'prog_code', 'address', 'city', 'phone_no', 'personal_email', 'bachelor_name', 'university_name', 'bachelor_cgpa', 'bachelor_year', 'admission_year', 'admission_date_sem1'], 'safe'],
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
        $query = StudentPostGrad::find();

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
            'date_birth' => $this->date_birth,
            'gender' => $this->gender,
            'marital_status' => $this->marital_status,
            'nationality' => $this->nationality,
            'citizenship' => $this->citizenship,
            'edu_level' => $this->edu_level,
            'student_email' => $this->student_email,
            'religion' => $this->religion,
            'race' => $this->race,
            'session' => $this->session,
            'admission_date_sem1' => $this->admission_date_sem1,
            'sponsor' => $this->sponsor,
            'student_current_sem' => $this->student_current_sem,
            'city_campus' => $this->city_campus,
            'student_status' => $this->student_status,
        ]);

        $query->andFilterWhere(['like', 'matric_no', $this->matric_no])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'nric', $this->nric])
            ->andFilterWhere(['like', 'prog_code', $this->prog_code])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'phone_no', $this->phone_no])
            ->andFilterWhere(['like', 'personal_email', $this->personal_email])
            ->andFilterWhere(['like', 'bachelor_name', $this->bachelor_name])
            ->andFilterWhere(['like', 'university_name', $this->university_name])
            ->andFilterWhere(['like', 'bachelor_cgpa', $this->bachelor_cgpa])
            ->andFilterWhere(['like', 'bachelor_year', $this->bachelor_year])
            ->andFilterWhere(['like', 'admission_year', $this->admission_year]);

        return $dataProvider;
    }
}
