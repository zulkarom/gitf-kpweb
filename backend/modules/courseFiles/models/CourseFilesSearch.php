<?php

namespace backend\modules\courseFiles\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\teachingLoad\models\CourseOffered;

/**
 * CourseOfferedSearch represents the model behind the search form of `backend\modules\teachingLoad\models\CourseOffered`.
 */
class CourseFilesSearch extends CourseOffered
{
    public $semester;
    public $program_id;
    public $search_course;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'semester_id', 'course_id','coordinator', 'is_audited', 'status', 'program_id'], 'integer'],
            [['prg_overall'], 'number'],
            [['search_course'], 'string'],
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
        $query = CourseOffered::find()
        ->joinWith('course c');

        // // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
             'query' => $query,
                'pagination' => [
                    'pageSize' => 150,
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
            
            'semester_id' => $this->semester,
            'c.program_id' => $this->program_id,
            'status' => $this->status,
            'is_audited' => $this->is_audited
            
        ]);

        if($this->prg_overall){
            if($this->prg_overall == 1){
                $query->andFilterWhere([
                    'prg_overall' => 0,
                ]);
            }else if($this->prg_overall == 25){
                $query->andFilterWhere([
                    '>', 'prg_overall', 0
                ]);
                $query->andFilterWhere([
                    '<=', 'prg_overall', 0.25
                ]);
            }else if($this->prg_overall == 50){
                $query->andFilterWhere([
                    '>', 'prg_overall', 0.25
                ]);
                $query->andFilterWhere([
                    '<=', 'prg_overall', 0.50
                ]);
            }else if($this->prg_overall == 75){
                $query->andFilterWhere([
                    '>', 'prg_overall', 0.5
                ]);
                $query->andFilterWhere([
                    '<=', 'prg_overall', 0.75
                ]);
            }else if($this->prg_overall == 99){
                $query->andFilterWhere([
                    '>', 'prg_overall', 0.75
                ]);
                $query->andFilterWhere([
                    '<', 'prg_overall', 1
                ]);
            }else if($this->prg_overall == 100){
                $query->andFilterWhere([
                    'prg_overall' => 1
                ]);
            }
        }

        
        $query->andFilterWhere(['or',
            ['like', 'course_code', $this->search_course],
            ['like', 'course_name', $this->search_course],
            ['like', 'course_name_bi', $this->search_course]
        ]);

        return $dataProvider;
    }
}
