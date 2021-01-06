<?php

namespace backend\modules\teachingLoad\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * CourseSearch represents the model behind the search form of `backend\modules\esiap\models\Course`.
 */
class CourseLectureStaffSearch extends Staff
{
    public $search_staff;
    public $semester;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['search_staff'], 'string'],
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
        $query = Staff::find()
        ->joinWith('user')
        ->where(['staff_active' => 1, 'is_academic' => 1, 'working_status' => 1])->orderBy('user.fullname ASC');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 200,
            ],

        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
         // grid filtering conditions
        $query->andFilterWhere(['like', 'fullname', $this->search_staff]);


        
        return $dataProvider;
    }
}
