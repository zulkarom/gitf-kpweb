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
    public $search_course;

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
        ->joinWith('course');

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
        $query->andFilterWhere(['like', 'course_code', $this->search_course]);


        $query->orFilterWhere(['like', 'course_name', $this->search_course])
            ->orFilterWhere(['like', 'course_name_bi', $this->search_course]);

        return $dataProvider;
    }
}
