<?php

namespace backend\modules\staff\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\staff\models\Staff;


/**
 * StaffSearch represents the model behind the search form of `backend\modules\staff\models\Staff`.
 */
class StaffSearch extends Staff
{
	public $staff_name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','is_academic', 'position_id', 'position_status', 'working_status', 'staff_department', 'faculty_id', 'staff_active'], 'integer'],
			
			[['staff_name', 'staff_title', 'staff_no'], 'string']
			

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
        $query = Staff::find()->orderBy('user.fullname ASC');
		$query->joinWith(['user']);
		$query->with(['workingStatus', 'staffPositionStatus']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
                'pageSize' => 100,
            ],

        ]);

        $this->load($params);

        // Default filters when not explicitly provided
        $filters = $params['StaffSearch'] ?? null;
        if (!isset($filters['faculty_id'])) {
            $this->faculty_id = 1;
        }
        if (!isset($filters['staff_active'])) {
            $this->staff_active = 1;
        }

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
			'position_id' => $this->position_id,
			'is_academic' => $this->is_academic,
			'position_status' => $this->position_status,
			'working_status' => $this->working_status,
            'faculty_id' => $this->faculty_id,
            'staff_active' => $this->staff_active,
        ]);

        $query->andFilterWhere(['like', 'staff_no', $this->staff_no]);
		$query->andFilterWhere(['like', 'user.fullname', $this->staff_name]);
		
		$dataProvider->sort->attributes['staff_name'] = [
        'asc' => ['user.fullname' => SORT_ASC],
        'desc' => ['user.fullname' => SORT_DESC],
        ]; 

        return $dataProvider;
    }
}
