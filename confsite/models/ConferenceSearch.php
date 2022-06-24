<?php

namespace confsite\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\conference\models\Conference;

/**
 * ConferenceSearch represents the model behind the search form of `backend\modules\conference\models\Conference`.
 */
class ConferenceSearch extends Conference
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['conf_name', 'conf_abbr', 'conf_date', 'conf_venue', 'conf_url'], 'safe'],
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
        $query = Conference::find()->where(['is_active' => 1])->orderBy('date_start DESC');

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
        ]);

        return $dataProvider;
    }
}
