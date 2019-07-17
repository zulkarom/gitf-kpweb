<?php

namespace backend\modules\erpd\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\erpd\models\Award;

/**
 * AwardSearch represents the model behind the search form of `backend\modules\erpd\models\Award`.
 */
class AwardSearch extends Award
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'awd_staff', 'awd_level'], 'integer'],
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
        $query = Award::find();

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
            'awd_staff' => Yii::$app->user->identity->staff->id,
            'awd_level' => $this->awd_level,
            'awd_date' => $this->awd_date,
        ]);

        $query->andFilterWhere(['like', 'awd_name', $this->awd_name])
            ->andFilterWhere(['like', 'awd_type', $this->awd_type])
            ->andFilterWhere(['like', 'awd_by', $this->awd_by])
            ->andFilterWhere(['like', 'awd_file', $this->awd_file]);

        return $dataProvider;
    }
}
