<?php

namespace backend\modules\erpd\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\erpd\models\Consultation;

/**
 * ConsultationSearch represents the model behind the search form of `backend\modules\erpd\models\Consultation`.
 */
class ConsultationLecturerSearch extends Consultation
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
            [['csl_level', 'duration', 'status'], 'integer'],
			
			[['staff_search', 'csl_title'], 'string'],
			
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
		
		 $query = Consultation::find()->where(['rp_consultation.status' => 50]);
		$query->joinWith(['staff.user']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort'=> ['defaultOrder' => ['status'=>SORT_ASC, 'date_start' =>SORT_DESC]],
			'pagination' => [
					'pageSize' => 10,
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
			'csl_staff' => $this->staff,
            'csl_level' => $this->csl_level,
        ]);

        $query->andFilterWhere(['like', 'csl_title', $this->csl_title])
		->andFilterWhere(['like', 'user.fullname', $this->staff_search]);
		
		$query->andFilterWhere(['<=', 'YEAR(date_start)', $this->duration]);
		 $query->andFilterWhere(['>=', 'YEAR(date_end)', $this->duration]);
		
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
