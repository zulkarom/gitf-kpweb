<?php

namespace backend\modules\postgrad\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * StudentPostGradSearch represents the model behind the search form of `backend\modules\postgrad\models\StudentPostGrad`.
 */
class StudentPostGradSearch extends Student
{
    public $name;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'gender', 'marital_status', 'nationality', 'citizenship', 'study_mode', 'religion', 'race', 'admission_semester', 'sponsor', 'current_sem', 'campus_id', 'status'], 'integer'],
            [['matric_no', 'nric', 'date_birth', 'program_code', 'address', 'city', 'phone_no', 'personal_email', 'bachelor_name', 'university_name', 'bachelor_cgpa', 'bachelor_year', 'admission_year', 'admission_date', 'name'], 'safe'],
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
        $query = Student::find()
        ->joinWith('user');

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
            'study_mode' => $this->study_mode,
            'religion' => $this->religion,
            'race' => $this->race,
            'admission_semester' => $this->admission_semester,
            'admission_date' => $this->admission_date,
            'sponsor' => $this->sponsor,
            'current_sem' => $this->current_sem,
            'campus_id' => $this->campus_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'matric_no', $this->matric_no])
            ->andFilterWhere(['like', 'nric', $this->nric])
            ->andFilterWhere(['like', 'program_code', $this->program_code])
            ->andFilterWhere(['like', 'user.fullname', $this->name]);

        return $dataProvider;
    }
}
