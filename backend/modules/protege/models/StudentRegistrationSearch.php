<?php

namespace backend\modules\protege\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\protege\models\StudentRegistration;

/**
 * StudentRegistrationSearch represents the model behind the search form of `backend\modules\protege\models\StudentRegistration`.
 */
class StudentRegistrationSearch extends StudentRegistration
{
    public $session_id;
    public $company_id;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['company_id','company_offer_id'], 'integer'],
            [['student_matric', 'student_name', 'program_abbr'], 'string'],
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
        $query = StudentRegistration::find()->alias('a')
        ->innerJoin('prtg_company_offer f', 'f.id = a.company_offer_id')
        ->where(['f.session_id' => $this->session_id]);

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
            'f.company_id' => $this->company_id,
            'a.program_abbr' => $this->program_abbr,
            'a.company_offer_id' => $this->company_offer_id,
        ]); 

        $query->andFilterWhere(['like', 'student_matric', $this->student_matric])
            ->andFilterWhere(['like', 'student_name', $this->student_name]);

        return $dataProvider;
    }
}
