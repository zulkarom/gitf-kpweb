<?php

namespace backend\modules\courseFiles\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\courseFiles\models\Material;

/**
 * MaterialAdminSearch represents the model behind the search form of `backend\modules\courseFiles\models\Material`.
 */
class MaterialAdminSearch extends Material
{
	public $course;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
			[['material_name', 'course'], 'string'],
            [['id', 'course_id', 'created_by', 'mt_type', 'status'], 'integer'],
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
        $query = Material::find()
		->joinWith('course')
		->orderBy('updated_at DESC');

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
		
		 $query->andFilterWhere([
            'status' => $this->status,
        ]);

        // grid filtering conditions
        $query->andFilterWhere(['or', 
            ['like', 'sp_course.course_name', $this->course],
            ['like', 'sp_course.course_name_bi', $this->course],
			['like', 'sp_course.course_code', $this->course],
        ]);


        $query->andFilterWhere(['like', 'material_name', $this->material_name]);
		
		
		

        return $dataProvider;
    }
}
