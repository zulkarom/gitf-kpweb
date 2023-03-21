<?php

namespace backend\modules\proceedings\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\proceedings\models\Proceeding;

/**
 * ProceedingSearch represents the model behind the search form of `backend\modules\proceedings\models\Proceeding`.
 */
class ProceedingSearch extends Proceeding
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['proc_name', 'date_start', 'date_end', 'image_file'], 'safe'],
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
        $query = Proceeding::find()->orderBy('date_start DESC');

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
            'date_start' => $this->date_start,
            'date_end' => $this->date_end,
        ]);

        $query->andFilterWhere(['like', 'proc_name', $this->proc_name])
            ->andFilterWhere(['like', 'image_file', $this->image_file]);

        return $dataProvider;
    }
}
