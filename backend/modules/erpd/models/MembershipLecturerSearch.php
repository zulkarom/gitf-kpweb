<?php

namespace backend\modules\erpd\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\erpd\models\Membership;

/**
 * MembershipSearch represents the model behind the search form of `backend\modules\erpd\models\Membership`.
 */
class MembershipLecturerSearch extends Membership
{
	public $staff;
	public $staff_search;
	public $duration;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'msp_staff', 'msp_level', 'duration', 'status'], 'integer'],
			
			[['staff_search'], 'string'],
			
            [['msp_body', 'msp_type', 'date_start', 'date_end', 'msp_file'], 'safe'],
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
        $query = Membership::find()->where(['>','rp_membership.status',10]);
		$query->joinWith(['staff.user']);
		
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort'=> ['defaultOrder' => ['status'=>SORT_ASC, 'date_start' =>SORT_DESC]],
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
            'rp_membership.status' => $this->status,
			'msp_level' => $this->msp_level,
			'msp_staff' => $this->staff
        ]);

        $query->andFilterWhere(['like', 'msp_body', $this->msp_body])
            ->andFilterWhere(['like', 'msp_type', $this->msp_type])
			->andFilterWhere(['like', 'user.fullname', $this->staff_search])
			;
		
		
		if($this->duration){
			$query->andFilterWhere(['<=', 'YEAR(date_start)', $this->duration]);
			$query->andFilterWhere(['or', 
				['>=', 'YEAR(date_end)', $this->duration],
				['date_end' => '0000-00-00']
			]);
		}
		
		 
			
		$dataProvider->sort->attributes['duration'] = [
        'asc' => ['date_start' => SORT_ASC],
        'desc' => ['date_start' => SORT_DESC],
        ]; 
		
		$dataProvider->sort->attributes['staff_search'] = [
        'asc' => ['user.fullname' => SORT_ASC],
        'desc' => ['user.fullname' => SORT_DESC],
        ]; 

        return $dataProvider;
    }
}
