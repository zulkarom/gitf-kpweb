<?php

namespace backend\modules\postgrad\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\University;

/**
 * UniversitySearch represents the model behind the search form of `backend\models\University`.
 */
class UniversitySearch extends University
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['uni_name', 'uni_name_en', 'uni_abbr', 'type', 'thrust', 'main_location'], 'safe'],
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
        $query = University::find();

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

        $query->andFilterWhere(['like', 'uni_name', $this->uni_name])
            ->andFilterWhere(['like', 'uni_name_en', $this->uni_name_en])
            ->andFilterWhere(['like', 'uni_abbr', $this->uni_abbr])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'thrust', $this->thrust])
            ->andFilterWhere(['like', 'main_location', $this->main_location]);

        return $dataProvider;
    }
}
