<?php

namespace backend\modules\teachingLoad\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\teachingLoad\models\CourseOffered;

/**
 * CourseOfferedSearch represents the model behind the search form of `backend\modules\teachingLoad\models\CourseOffered`.
 */
class CourseOfferedSearch extends CourseOffered
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'semester_id', 'course_id', 'created_by', 'coordinator'], 'integer'],
            [['created_at'], 'safe'],
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
        $query = CourseOffered::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'semester_id' => $this->semester_id,
            'course_id' => $this->course_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'coordinator' => $this->coordinator,
        ]);

        return $dataProvider;
    }
}
