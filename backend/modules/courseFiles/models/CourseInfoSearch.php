<?php

namespace backend\modules\courseFiles\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\teachingLoad\models\CourseOffered;

/**
 * CourseSearch represents the model behind the search form of `backend\modules\esiap\models\Course`.
 */
class CourseInfoSearch extends CourseOffered
{
	public $search_course;
    public $semester;
    public $status;
	public $search_cat;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['search_course'], 'string'],
			
			[['search_cat'], 'integer'],
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

        $query = CourseOffered::find()
        ->joinWith('courseVersion v')
        ->where([
            'v.status' => [10, 20, 17]
            ])->orderBy('v.status ASC, v.prepared_at DESC');

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
		
        $query->andFilterWhere([
            
            'semester_id' => $this->semester,
            'v.status' => $this->status
            
        ]);


        return $dataProvider;
    }
}
