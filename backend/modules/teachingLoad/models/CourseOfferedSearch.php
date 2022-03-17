<?php

namespace backend\modules\teachingLoad\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\teachingLoad\models\CourseOffered;
use yii\db\Expression;

/**
 * CourseOfferedSearch represents the model behind the search form of `backend\modules\teachingLoad\models\CourseOffered`.
 */
class CourseOfferedSearch extends CourseOffered
{
    public $semester;
    public $search_course;
	public $search_program;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'semester_id', 'course_id', 'created_by', 'coordinator'], 'integer'],
            [['created_at'], 'safe'],
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
        ->joinWith('course c')
        ->orderBy( new Expression("FIELD(c.study_level,'UG','PG'), c.course_name ASC"));

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
            
        ]);

        // grid filtering conditions
		$query->andFilterWhere(['program_id' => $this->search_program]);
		$query->andFilterWhere(['or', 
            ['like', 'course_name', $this->search_course],
            ['like', 'course_name_bi', $this->search_course],
			['like', 'course_code', $this->search_course]
        ]);



        return $dataProvider;
    }
}
