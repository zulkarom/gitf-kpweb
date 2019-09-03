<?php

namespace backend\modules\erpd\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\erpd\models\Research;

/**
 * ResearchSearch represents the model behind the search form of `backend\modules\erpd\models\Research`.
 */
class ResearchSearch extends Research
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'res_staff', 'res_progress', 'res_grant', 'reminder', 'status'], 'integer'],
			
            [['res_title', 'date_start', 'date_end', 'res_grant_others', 'res_source', 'res_file', 'modified_at', 'created_at'], 'safe'],
			
            [['res_amount'], 'number'],
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
        $query = Research::find();
		$query->joinWith(['researchers']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'rp_researcher.staff_id' => Yii::$app->user->identity->staff->id,
        ]);

        $query->andFilterWhere(['like', 'res_title', $this->res_title]);


        return $dataProvider;
    }
}
