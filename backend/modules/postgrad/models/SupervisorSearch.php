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
    
    public $svNameSearch;
    public $svFieldsSearch;
    public $field_id; // for dropdown filter on fields
    public $color; // red, yellow, green
    public $semester_id;
    public $sv_role; // 1 = main, 2 = co-supervisor
    public $faculty_scope; // academic | other
    public $staff_active; // filter by staff.staff_active for internal supervisors
    public $require_students; // if set, only show supervisors with supervisees in selected semester

    public function attributes()
    {
        return array_merge(parent::attributes(), ['total_count', 'main_count', 'second_count']);
    }
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_internal', 'field_id', 'semester_id', 'sv_role', 'staff_active', 'require_students'], 'integer'],
            [['svNameSearch', 'svFieldsSearch', 'color', 'faculty_scope'], 'string'],
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

        if (empty($this->semester_id) && isset($params['semester_id'])) {
            $this->semester_id = (int)$params['semester_id'];
        }

        $semesterId = $this->semester_id;

        $query = static::find()->alias('a')
        ->joinWith(['staff.user u', 'external x', 'svFields.field f'], false)
        ->leftJoin('pg_student_sv ss', 'ss.supervisor_id = a.id')
        ->leftJoin('pg_student st', 'st.id = ss.student_id')
        ->leftJoin('pg_student_reg sr', 'sr.student_id = ss.student_id' . (!empty($semesterId) ? ' AND sr.semester_id = ' . (int)$semesterId : ''));

        $query->select(['a.*']);
        $query->addSelect([
            'total_count' => 'COUNT(DISTINCT sr.student_id)',
            'main_count' => 'COUNT(DISTINCT CASE WHEN ss.sv_role = 1 AND sr.id IS NOT NULL THEN ss.student_id END)',
            'second_count' => 'COUNT(DISTINCT CASE WHEN ss.sv_role = 2 AND sr.id IS NOT NULL THEN ss.student_id END)',
        ]);

        $query->groupBy('a.id');

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

        if ((int)$this->is_internal === 0) {
            $query->andWhere(['>', 'a.external_id', 0]);
        }

        if (!empty($this->faculty_scope) && (int)$this->is_internal === 1) {
            switch (strtolower($this->faculty_scope)) {
                case 'academic':
                    $query->andWhere(['staff.faculty_id' => 1]);
                    break;
                case 'other':
                    $query->andWhere(['<>', 'staff.faculty_id', 1]);
                    break;
            }
        }

        if ($this->staff_active !== null && (int)$this->is_internal === 1) {
            $query->andWhere(['staff.staff_active' => (int)$this->staff_active]);
        }
        
        $query->andFilterWhere(['or',
            ['like', 'u.fullname', $this->svNameSearch],
            ['like', 'x.ex_name', $this->svNameSearch]
        ]);
        
        // filter by supervisor expertise field via pg_sv_field -> field f
        $query->andFilterWhere([
            'f.id' => $this->field_id
        ]);
        
        // still allow text search on field name if used
        $query->andFilterWhere(
            ['like', 'f.field_name', $this->svFieldsSearch]
        );

        // filter by role (main/co) using aggregates computed in SELECT
        if (!empty($this->sv_role)) {
            switch ((int)$this->sv_role) {
                case 1:
                    $query->andHaving('COUNT(DISTINCT CASE WHEN ss.sv_role = 1 AND sr.id IS NOT NULL THEN ss.student_id END) > 0');
                    break;
                case 2:
                    $query->andHaving('COUNT(DISTINCT CASE WHEN ss.sv_role = 2 AND sr.id IS NOT NULL THEN ss.student_id END) > 0');
                    break;
            }
        }

        if (!empty($this->require_students)) {
            $query->andHaving('COUNT(DISTINCT sr.student_id) > 0');
        }

        // color filter mapped to total supervisee count
        if (!empty($this->color)) {
            switch (strtolower($this->color)) {
                case 'green':
                    // 0 - 3
                    $query->andHaving('COUNT(DISTINCT sr.student_id) BETWEEN 0 AND 3');
                    break;
                case 'yellow':
                    // 4 - 7
                    $query->andHaving('COUNT(DISTINCT sr.student_id) BETWEEN 4 AND 7');
                    break;
                case 'red':
                    // 8 and above
                    $query->andHaving('COUNT(DISTINCT sr.student_id) >= 8');
                    break;
            }
        }
        
        return $dataProvider;
    }
}
