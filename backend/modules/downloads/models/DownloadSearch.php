<?php

namespace backend\modules\downloads\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\downloads\models\Download;

/**
 * DownloadSearch represents the model behind the search form of `backend\modules\downloads\models\Download`.
 */
class DownloadSearch extends Download
{
	public $category;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'category_id'], 'integer'],
			[['nric'], 'string'],
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
        $query = Download::find();

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
            'category_id' => $this->category,
        ]);

		
		$query->andFilterWhere(
            ['like', 'nric', $this->nric]
        );


        return $dataProvider;
    }
}
