<?php

namespace backend\modules\manual\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\manual\models\Item;

/**
 * ItemSearch represents the model behind the search form of `backend\modules\manual\models\Item`.
 */
class ItemSearch extends Item
{
    public $title;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'title_id'], 'integer'],
            [['item_text'], 'safe'],
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
        $query = Item::find();

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
            'title_id' => $this->title,
        ]);

        $query->andFilterWhere(['like', 'item_text', $this->item_text]);

        return $dataProvider;
    }
}
