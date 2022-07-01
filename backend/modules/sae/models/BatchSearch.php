<?php

namespace backend\modules\sae\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\sae\models\Batch;

/**
 * BatchSearch represents the model behind the search form of `backend\models\Batch`.
 */
class BatchSearch extends Batch
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'bat_show'], 'integer'],
            [['bat_text'], 'safe'],
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
        $query = Batch::find();

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
            'bat_show' => $this->bat_show,
        ]);

        $query->andFilterWhere(['like', 'bat_text', $this->bat_text]);

        return $dataProvider;
    }
}
