<?php

namespace backend\modules\postgrad\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\postgrad\models\Supervisor;

/**
 * SupervisorSearch represents the model behind the search form of `backend\modules\postgrad\models\Supervisor`.
 */
class SupervisorSearch extends Supervisor
{
    
    public $svName;
    public $svFieldsString;
    public $field_id; // for dropdown filter on fields
    public $color; // red, yellow, green
    public $semester_id;
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_internal', 'field_id', 'semester_id'], 'integer'],
            [['svName', 'svFieldsString', 'color'], 'string'],
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
        $this->load($params);

        $semesterId = $this->semester_id;

        $query = Supervisor::find()->alias('a')
        ->select([
            'a.*',
            'total_count' => 'COUNT(sr.id)',
            'main_count' => 'SUM(CASE WHEN ss.sv_role = 1 AND sr.id IS NOT NULL THEN 1 ELSE 0 END)',
            'second_count' => 'SUM(CASE WHEN ss.sv_role = 2 AND sr.id IS NOT NULL THEN 1 ELSE 0 END)'
        ])
        ->joinWith(['staff.user u', 'external x', 'svFields.field f'])
        ->leftJoin('pg_student_sv ss', 'ss.supervisor_id = a.id')
        ->leftJoin('pg_student st', 'st.id = ss.student_id')
        ->leftJoin('pg_student_reg sr', 'sr.student_id = ss.student_id' . (!empty($semesterId) ? ' AND sr.semester_id = ' . (int)$semesterId : ''));

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 150,
            ],
            'sort' => [
                'defaultOrder' => [
                    'svName' => SORT_ASC,
                ],
                'attributes' => [
                    'svName' => [
                        'asc' => [new \yii\db\Expression('COALESCE(u.fullname, x.ex_name) ASC')],
                        'desc' => [new \yii\db\Expression('COALESCE(u.fullname, x.ex_name) DESC')],
                        'label' => 'Name',
                    ],
                    'svFieldsString' => [
                        'asc' => ['f.field_name' => SORT_ASC],
                        'desc' => ['f.field_name' => SORT_DESC],
                        'label' => 'Fields',
                    ],
                    'main_count' => [
                        'asc' => ['main_count' => SORT_ASC],
                        'desc' => ['main_count' => SORT_DESC],
                        'label' => 'Penyelia Utama',
                    ],
                    'second_count' => [
                        'asc' => ['second_count' => SORT_ASC],
                        'desc' => ['second_count' => SORT_DESC],
                        'label' => 'Penyelia Bersama',
                    ],
                    'total_count' => [
                        'asc' => ['total_count' => SORT_ASC],
                        'desc' => ['total_count' => SORT_DESC],
                        'label' => 'Jumlah Penyeliaan',
                    ],
                ],
            ],
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'is_internal' => $this->is_internal
        ]);
        
        $query->andFilterWhere(['or',
            ['like', 'u.fullname', $this->svName],
            ['like', 'x.ex_name', $this->svName]
        ]);
        
        // filter by supervisor expertise field via pg_sv_field -> field f
        $query->andFilterWhere([
            'f.id' => $this->field_id
        ]);
        
        // still allow text search on field name if used
        $query->andFilterWhere(
            ['like', 'f.field_name', $this->svFieldsString]
        );

        // group by supervisor to allow aggregate filtering and to prevent duplicates
        $query->groupBy('a.id');

        // color filter mapped to total supervisee count
        if (!empty($this->color)) {
            switch (strtolower($this->color)) {
                case 'red':
                    // 0 - 3
                    $query->having('COUNT(sr.id) BETWEEN 0 AND 3');
                    break;
                case 'yellow':
                    // 4 - 7
                    $query->having('COUNT(sr.id) BETWEEN 4 AND 7');
                    break;
                case 'green':
                    // 8 and above
                    $query->having('COUNT(sr.id) >= 8');
                    break;
            }
        }
        
        return $dataProvider;
    }
}
