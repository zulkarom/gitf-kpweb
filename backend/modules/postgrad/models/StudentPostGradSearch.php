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
    public $study_mode_rc;
    public $pro_level;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'gender', 'status', 'nationality', 'field_id', 'pro_level', 'status_daftar', 'status_aktif'], 'integer'],
            [['matric_no', 'nric', 'program_id', 'name', 'study_mode_rc'], 'safe'],
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
        $query = Student::find()->alias('a')
        ->joinWith([
            'user',
            'program' => function($q) {
                $q->alias('program');
            }
        ])->orderBy('a.id DESC');

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
            'program_id' => $this->program_id,
            'a.status' => $this->status,
            'a.nationality' => $this->nationality,
            'a.field_id' => $this->field_id,
            'a.status_daftar' => $this->status_daftar,
            'a.status_aktif' => $this->status_aktif,
        ]);

        $query->andFilterWhere([
            'program.pro_level' => $this->pro_level,
        ]);

        $query->andFilterWhere(['like', 'matric_no', $this->matric_no])
            ->andFilterWhere(['like', 'nric', $this->nric]);

        if ($this->name) {
            $query->andFilterWhere(['or',
                ['like', 'user.fullname', $this->name],
                ['like', 'a.matric_no', $this->name],
                ['like', 'a.nric', $this->name],
            ]);
        }

        // study mode (research/coursework)
        $query->andFilterWhere(['a.study_mode_rc' => $this->study_mode_rc]);

        return $dataProvider;
    }
}
