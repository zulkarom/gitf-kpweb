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
            [['id', 'staff_no','is_academic', 'position_id', 'position_status', 'working_status', 'staff_department', 'publish'], 'integer'],
			
			[['staff_name', 'staff_title'], 'string']
			

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
        $query = Staff::find()->where(['staff_active' => 1]);
		$query->joinWith(['user']);

        // add conditions that should always apply here

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
            'id' => $this->id,
			'staff_no' => $this->staff_no,
			'position_id' => $this->position_id
        ]);

        $query->andFilterWhere(['like', 'staff_no', $this->staff_no]);
		
		$dataProvider->sort->attributes['staff_name'] = [
        'asc' => ['user.fullname' => SORT_ASC],
        'desc' => ['user.fullname' => SORT_DESC],
        ]; 

        return $dataProvider;
    }
}
