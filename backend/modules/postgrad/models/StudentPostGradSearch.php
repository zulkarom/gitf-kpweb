<?php

namespace backend\modules\postgrad\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Semester;
use backend\modules\postgrad\models\StudentRegister;

/**
 * StudentPostGradSearch represents the model behind the search form of `backend\modules\postgrad\models\StudentPostGrad`.
 */
class StudentPostGradSearch extends Student
{
    public $name;
    public $study_mode_rc;
    public $pro_level;
    public $semester_id;
    public $status;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'gender', 'status', 'nationality', 'field_id', 'pro_level', 'status_daftar', 'status_aktif', 'semester_id'], 'integer'],
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
        $semesterId = isset($params['semester_id']) ? (int)$params['semester_id'] : 0;
        if (!$semesterId) {
            $currentSem = Semester::getCurrentSemester();
            if ($currentSem) {
                $semesterId = (int)$currentSem->id;
            }
        }
        $this->semester_id = $semesterId;

        $query = Student::find()->alias('a')
        ->select([
            'a.*',
            'status_daftar' => 'r.status_daftar',
            'status_aktif' => 'r.status_aktif',
        ])
        ->innerJoin(
            ['r' => StudentRegister::tableName()],
            'r.student_id = a.id AND r.semester_id = :semesterId',
            [':semesterId' => (int)$semesterId]
        )
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
            // use registration status from pg_student_reg instead of dropped a.status
            'r.status_aktif' => $this->status,
            'a.nationality' => $this->nationality,
            'a.field_id' => $this->field_id,
            'r.status_daftar' => $this->status_daftar,
            'r.status_aktif' => $this->status_aktif,
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

    public function statusDaftarList(){
        return StudentRegister::statusDaftarList();
    }

    public function statusAktifList(){
        return StudentRegister::statusAktifList();
    }
}
