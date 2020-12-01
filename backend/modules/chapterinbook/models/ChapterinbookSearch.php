<?php

namespace backend\modules\chapterinbook\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\chapterinbook\models\Chapterinbook;

/**
 * chapterinbookearch represents the model behind the search form of `backend\modules\chapterinbook\models\Proceeding`.
 */
class ChapterinbookSearch extends Chapterinbook
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['chap_name', 'date_start', 'date_end', 'image_file'], 'safe'],
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
        $query = Chapterinbook::find();

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
        ]);

        $query->andFilterWhere(['like', 'chap_name', $this->chap_name])
            ->andFilterWhere(['like', 'image_file', $this->image_file]);

        return $dataProvider;
    }
}
