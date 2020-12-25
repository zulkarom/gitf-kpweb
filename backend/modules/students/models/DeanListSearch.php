<?php

namespace backend\modules\students\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\students\models\DeanList;

/**
 * DeanListSearch represents the model behind the search form of `backend\modules\students\models\DeanList`.
 */
class DeanListSearch extends DeanList
{
	public $semester;
	public $str_search;
	public $name;
	public $nric;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['semester'], 'integer'],
            [['str_search'], 'string'],
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
        $query = DeanList::find();
		$query->joinWith(['student']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort'=> ['defaultOrder' => ['created_at'=>SORT_DESC]],
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
        $query->andFilterWhere([
            'id' => $this->id,
            'semester_id' => $this->semester,
        ]);

       
		
		$dataProvider->sort->attributes['name'] = [
        'asc' => ['st_student.st_name' => SORT_ASC],
        'desc' => ['st_student.st_name' => SORT_DESC],
        ]; 
		
		$dataProvider->sort->attributes['nric'] = [
        'asc' => ['st_student.nric' => SORT_ASC],
        'desc' => ['st_student.nric' => SORT_DESC],
        ]; 
		

		 
		 $query->andFilterWhere(['or', 
            ['like', 'st_student.matric_no', $this->str_search],
            ['like', 'st_student.st_name', $this->str_search],
			['like', 'st_student.nric', $this->str_search]
        ]);



        return $dataProvider;
    }
}
