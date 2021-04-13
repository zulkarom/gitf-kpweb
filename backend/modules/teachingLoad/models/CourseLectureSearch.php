<?php

namespace backend\modules\teachingLoad\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\teachingLoad\models\Course;

/**
 * CourseSearch represents the model behind the search form of `backend\modules\esiap\models\Course`.
 */
class CourseLectureSearch extends Course
{
	public $search_course;
	
	public $search_program;
	
	public $semester;
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['search_course'], 'string'],
        ];
    }

    /**
     * @inheritdoc
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
        /* $query = Course::find()
		->where([
			'faculty_id' => Yii::$app->params['faculty_id'], 
			'is_active' => 1, 'is_dummy' => 0, 
			'method_type' => 1]
		)
		->orderBy('course_code ASC'); */
		
		$query = CourseOffered::find()
        ->joinWith('course');

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
		
		
		$query->andFilterWhere(['program_id' => $this->search_program]);
		
		// grid filtering conditions
        $query->andFilterWhere(['or', 
            ['like', 'course_name', $this->search_course],
            ['like', 'course_name_bi', $this->search_course],
			['like', 'course_code', $this->search_course]
        ]);

        return $dataProvider;
    }
	
	
}
