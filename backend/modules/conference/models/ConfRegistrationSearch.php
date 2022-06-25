<?php

namespace backend\modules\conference\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\conference\models\ConfRegistration;

/**
 * ConfRegistrationSearch represents the model behind the search form of `backend\modules\conference\models\ConfRegistration`.
 */
class ConfRegistrationSearch extends ConfRegistration
{
	public $fullname;
	public $email;
	
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'conf_id', 'user_id', 'is_author', 'is_reviewer', 'fee_status'], 'integer'],
			[['email', 'fullname', 'institution'], 'string'],
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
        $query = ConfRegistration::find()->where(['conf_id' => $this->conf_id]);
		$query->joinWith(['user', 'associate']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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

        $query->andFilterWhere([
            'is_author' => $this->is_author,
            'is_reviewer' => $this->is_reviewer,
            'fee_status' => $this->fee_status,
        ]);

        $query->andFilterWhere(['like', 'user.fullname', $this->fullname]);
        $query->andFilterWhere(['like', 'user.email', $this->email]);
		
		$dataProvider->sort->attributes['fullname'] = [
        'asc' => ['user.fullname' => SORT_ASC],
        'desc' => ['user.fullname' => SORT_DESC],
        ]; 
		
		$dataProvider->sort->attributes['email'] = [
        'asc' => ['user.email' => SORT_ASC],
        'desc' => ['user.email' => SORT_DESC],
        ]; 




        return $dataProvider;
    }
}
