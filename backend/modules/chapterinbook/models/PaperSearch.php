<?php

namespace backend\modules\chapterinbook\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\chapterinbook\models\Paper;

/**
 * ProjectSearch represents the model behind the search form of `backend\modules\chapterinbook\models\Paper`.
 */
class PaperSearch extends Paper
{
	
	public $proceeding;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'chap_id', 'paper_no'], 'integer'],
            [['paper_title', 'author', 'paper_page', 'paper_file'], 'safe'],
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
        $query = Paper::find();

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
            'chap_id' => $this->proceeding,
            'paper_no' => $this->paper_no,
        ]);

        $query->andFilterWhere(['like', 'paper_title', $this->paper_title])
            ->andFilterWhere(['like', 'author', $this->author])
            ->andFilterWhere(['like', 'paper_page', $this->paper_page])
            ->andFilterWhere(['like', 'paper_file', $this->paper_file]);

        return $dataProvider;
    }
}
