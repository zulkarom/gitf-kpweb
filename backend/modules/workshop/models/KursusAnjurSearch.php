<?php

namespace backend\modules\workshop\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * KursusAnjurSearch represents the model behind the search form of `backend\modules\postgrad\models\KursusAnjur`.
 */
class KursusAnjurSearch extends KursusAnjur
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'capacity', 'kategori_id'], 'integer'],
            [['kursus_name', 'location'], 'string'],
            [['date_start', 'date_end',], 'safe'],
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
        $query = KursusAnjur::find();

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
            'capacity' => $this->capacity,
            'kategori_id' => $this->kategori_id,
        ]);

        $query->andFilterWhere(['like', 'kursus_name', $this->kursus_name])
            ->andFilterWhere(['like', 'location', $this->location]);

        return $dataProvider;
    }
}
