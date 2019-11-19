<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\proceedings\models\Paper;

/**
 * ProjectSearch represents the model behind the search form of `backend\modules\proceedings\models\Paper`.
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
            [['id', 'proc_id', 'paper_no'], 'integer'],
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
			'pagination' => [
                'pageSize' => 100,
            ],
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
            'proc_id' => $this->proceeding,
            'paper_no' => $this->paper_no,
        ]);

        $query->andFilterWhere(['like', 'paper_title', $this->paper_title])
            ->andFilterWhere(['like', 'author', $this->author])
            ->andFilterWhere(['like', 'paper_page', $this->paper_page])
            ->andFilterWhere(['like', 'paper_file', $this->paper_file]);

        return $dataProvider;
    }
}
