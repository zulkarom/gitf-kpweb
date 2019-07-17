<?php

namespace backend\modules\website\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\website\models\Event;

/**
 * EventSearch represents the model behind the search form of `backend\modules\website\models\Event`.
 */
class EventSearch extends Event
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_by'], 'integer'],
            [['name', 'date_start', 'date_end', 'time_start', 'time_end', 'created_at', 'updated_at', 'venue', 'register_link', 'intro_promo'], 'safe'],
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
        $query = Event::find()->orderBy('date_start DESC');

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
            'time_start' => $this->time_start,
            'time_end' => $this->time_end,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'venue', $this->venue])
            ->andFilterWhere(['like', 'register_link', $this->register_link])
            ->andFilterWhere(['like', 'intro_promo', $this->intro_promo]);

        return $dataProvider;
    }
}
