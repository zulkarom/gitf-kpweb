<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class UrlredirectSearch extends Urlredirect
{
    public function rules()
    {
        return [
            [['id', 'hit_counter', 'latest_hit'], 'integer'],
            [['code', 'url_to'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Urlredirect::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
            ],
            'pagination' => [
                'pageSize' => 50,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'hit_counter' => $this->hit_counter,
            'latest_hit' => $this->latest_hit,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'url_to', $this->url_to]);

        return $dataProvider;
    }
}
