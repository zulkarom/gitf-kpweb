<?php

namespace backend\modules\erpd\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\erpd\models\Award;

/**
 * AwardSearch represents the model behind the search form of `backend\modules\erpd\models\Award`.
 */
class AwardLecturerSearch extends Award
{
	public $staff;
	public $duration;
	public $staff_search;
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'awd_staff', 'awd_level', 'duration', 'status'], 'integer'],
			
			[['staff_search'], 'string'],
			
            [['awd_name', 'awd_type', 'awd_by', 'awd_date', 'awd_file'], 'safe'],
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
		
		
		 $query = Award::find()->where(['>','rp_award.status',10]);
		$query->joinWith(['staff.user']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort'=> ['defaultOrder' => ['status'=>SORT_ASC, 'awd_date' =>SORT_DESC]],
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

        // grid filtering conditions
        $query->andFilterWhere([
            'awd_level' => $this->awd_level,
			'awd_staff' => $this->staff,
			'YEAR(awd_date)' => $this->duration,
			'rp_award.status' => $this->status
        ]);

        $query->andFilterWhere(['like', 'awd_name', $this->awd_name])
		->andFilterWhere(['like', 'user.fullname', $this->staff_search]);
		
		$dataProvider->sort->attributes['duration'] = [
        'asc' => ['awd_date' => SORT_ASC],
        'desc' => ['awd_date' => SORT_DESC],
        ]; 
		
		$dataProvider->sort->attributes['staff_search'] = [
        'asc' => ['user.fullname' => SORT_ASC],
        'desc' => ['user.fullname' => SORT_DESC],
        ]; 
		

        return $dataProvider;
    }
}
