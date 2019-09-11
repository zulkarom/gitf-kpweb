<?php

namespace backend\modules\erpd\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\erpd\models\KnowledgeTransfer;

/**
 * KnowledgeTransferSearch represents the model behind the search form of `backend\modules\erpd\models\KnowledgeTransfer`.
 */
class KnowledgeTransferAllSearch extends KnowledgeTransfer
{
	public $duration;
	public $staff_search;
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['duration', 'status'], 'integer'],
			
			[['staff_search', 'ktp_title', 'ktp_community'], 'string'],
			
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
		
		$query = KnowledgeTransfer::find()->where(['>','rp_knowledge_transfer.status',10]);
		$query->joinWith(['members', 'staff.user']);

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
            'id' => $this->id,
			'rp_knowledge_transfer.status' => $this->status

        ]);

        $query->andFilterWhere(['like', 'ktp_title', $this->ktp_title])
		->andFilterWhere(['like', 'ktp_community', $this->ktp_community])
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
