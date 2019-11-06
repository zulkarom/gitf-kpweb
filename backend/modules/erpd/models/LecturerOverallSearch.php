<?php

namespace backend\modules\erpd\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\staff\models\Staff;

/**
 * PublicationSearch represents the model behind the search form of `backend\modules\erpd\models\Publication`.
 */
class LecturerOverallSearch extends Staff
{
	public $fullname;
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['staff_no'], 'string'],
			
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
        $query = Staff::find()->where(['is_academic' => 1, 'staff_active' => 1, 'faculty_id' => Yii::$app->params['faculty_id']])->orderBy('user.fullname ASC');
		$query->joinWith(['user']);

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



        return $dataProvider;
    }
}
