<?php

namespace backend\modules\teachingLoad\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\teachingLoad\models\CourseOffered;

/**
 * CourseOfferedSearch represents the model behind the search form of `backend\modules\teachingLoad\models\CourseOffered`.
 */
class ContactHourSearch extends CourseOffered
{
    public $search_course;
	public $lec_hour;
	public $tut_hour;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['search_course'], 'string'],
			[['lec_hour', 'tut_hour'], 'number'],
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
        ->joinWith('course');

        // // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
             'query' => $query,
                'pagination' => [
                    'pageSize' => 50,
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
            
            'sp_course.lec_hour' => $this->lec_hour,
			'sp_course.tut_hour' => $this->tut_hour,
            
        ]);
		
		$query->andFilterWhere(['or', 
            ['like', 'course_code', $this->search_course],
            ['like', 'course_name', $this->search_course],
			['like', 'course_name_bi', $this->search_course]
        ]);


        return $dataProvider;
    }
}
