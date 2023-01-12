<?php

namespace backend\modules\postgrad\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\teachingLoad\models\CourseOffered;
use common\models\Common;

/**
 * CourseOfferedSearch represents the model behind the search form of `backend\modules\teachingLoad\models\CourseOffered`.
 */
class CourseworkSearch extends CourseOffered
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
            [['semester_id','program_id'], 'integer'],
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
        $query = CourseOffered::find()->alias('f')
        ->innerJoin('sp_course c', 'c.id = f.course_id')
        ->where(['c.program_id' => Common::arrayPgCoursework()]);

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
            'semester_id' => $this->semester
        ]);

        if($this->program_id){
            $query->andFilterWhere([
            'program_id' => $this->program_id
        ]);
        }

        //Common::arrayPgCoursework()

        return $dataProvider;
    }
}
