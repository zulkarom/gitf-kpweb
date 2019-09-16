<?php

namespace backend\modules\jeb\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\jeb\models\Journal;

/**
 * JournalSearch represents the model behind the search form of `backend\modules\jeb\models\Journal`.
 */
class JournalSearch extends Journal
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['volume', 'issue', 'status'], 'integer'],
			
            [['journal_name'], 'string'],
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
        $query = Journal::find()->orderBy('status ASC, volume DESC, issue DESC');

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
            'volume' => $this->volume,
            'issue' => $this->issue,
            'status' => $this->status,
            'published_at' => $this->published_at,
            'archived_at' => $this->archived_at,
        ]);

        $query->andFilterWhere(['like', 'journal_name', $this->journal_name]);


        return $dataProvider;
    }
}
