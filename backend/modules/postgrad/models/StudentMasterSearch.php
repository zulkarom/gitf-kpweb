<?php

namespace backend\modules\postgrad\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\postgrad\models\StudentRegister;

class StudentMasterSearch extends Student
{
    public $name;
    public $study_mode_rc;
    public $pro_level;

    public function rules()
    {
        return [
            [['id', 'gender', 'nationality', 'field_id', 'pro_level', 'status_daftar', 'study_mode'], 'integer'],
            [['matric_no', 'nric', 'program_id', 'name', 'study_mode_rc'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $studentColumns = array_keys(static::getTableSchema()->columns);
        $studentColumns = array_values(array_diff($studentColumns, ['status_daftar', 'status_aktif']));
        $studentSelect = [];
        foreach ($studentColumns as $c) {
            $studentSelect[] = 'a.' . $c;
        }

        $query = Student::find()->alias('a')
            ->select(array_merge($studentSelect, [
                'status_daftar' => 'a.last_status_daftar',
            ]))
            ->joinWith([
                'user',
                'program' => function($q) {
                    $q->alias('program');
                }
            ])
            ->orderBy('a.id DESC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'program_id' => $this->program_id,
            'a.nationality' => $this->nationality,
            'a.field_id' => $this->field_id,
            'a.study_mode' => $this->study_mode,
            'a.last_status_daftar' => $this->status_daftar,
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

        $query->andFilterWhere(['a.study_mode_rc' => $this->study_mode_rc]);

        return $dataProvider;
    }

    public function statusDaftarList()
    {
        return StudentRegister::statusDaftarList();
    }
}
