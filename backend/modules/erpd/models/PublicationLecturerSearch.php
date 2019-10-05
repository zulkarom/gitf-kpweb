<?php

namespace backend\modules\erpd\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\erpd\models\Publication;

/**
 * PublicationSearch represents the model behind the search form of `backend\modules\erpd\models\Publication`.
 */
class PublicationLecturerSearch extends Publication
{
	public $staff;
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pub_type', 'pub_year', 'status'], 'integer'],
			
            [['pub_title'], 'string'],
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
        $query = Publication::find()->where(['status' => 50 ]);
		$query->joinWith('pubTags');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort'=> ['defaultOrder' => ['status'=>SORT_ASC, 'pub_year' =>SORT_DESC, 'pub_type' => SORT_ASC]],
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
            'rp_pub_tag.staff_id' => $this->staff,
			'pub_type' => $this->pub_type,
            'pub_year' => $this->pub_year,
        ]);

        $query->andFilterWhere(['like', 'pub_title', $this->pub_title]);

        return $dataProvider;
    }
}
