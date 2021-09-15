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
    public $name;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'gender', 'marital_status', 'nationality', 'citizenship', 'edu_level', 'religion', 'race', 'session', 'sponsor', 'student_current_sem', 'city_campus', 'student_status'], 'integer'],
            [['matric_no', 'nric', 'date_birth', 'prog_code', 'address', 'city', 'phone_no', 'personal_email', 'bachelor_name', 'university_name', 'bachelor_cgpa', 'bachelor_year', 'admission_year', 'admission_date_sem1', 'name'], 'safe'],
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
        $query = StudentPostGrad::find()
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
            'edu_level' => $this->edu_level,
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
            ->andFilterWhere(['like', 'nric', $this->nric])
            ->andFilterWhere(['like', 'prog_code', $this->prog_code])
            ->andFilterWhere(['like', 'user.fullname', $this->name]);

        return $dataProvider;
    }
}
