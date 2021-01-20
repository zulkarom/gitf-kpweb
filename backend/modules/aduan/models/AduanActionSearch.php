<?php

namespace backend\modules\aduan\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\aduan\models\AduanAction;

/**
 * AduanActionSearch represents the model behind the search form of `backend\modules\aduan\models\AduanAction`.
 */
class AduanActionSearch extends AduanAction
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'aduan_id', 'created_by'], 'integer'],
            [['created_at', 'updated_at', 'title', 'action_text'], 'safe'],
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
        $query = AduanAction::find();

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
            'aduan_id' => $this->aduan_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'action_text', $this->action_text]);

        return $dataProvider;
    }
}
