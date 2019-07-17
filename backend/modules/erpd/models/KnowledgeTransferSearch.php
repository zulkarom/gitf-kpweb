<?php

namespace backend\modules\erpd\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\erpd\models\KnowledgeTransfer;

/**
 * KnowledgeTransferSearch represents the model behind the search form of `backend\modules\erpd\models\KnowledgeTransfer`.
 */
class KnowledgeTransferSearch extends KnowledgeTransfer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'staff_id', 'reminder'], 'integer'],
            [['ktp_title', 'date_start', 'date_end', 'ktp_research', 'ktp_community', 'ktp_source', 'ktp_description', 'ktp_file', 'created_at', 'updated_at'], 'safe'],
            [['ktp_amount'], 'number'],
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
        $query = KnowledgeTransfer::find();

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
            'staff_id' => $this->staff_id,
            'date_start' => $this->date_start,
            'date_end' => $this->date_end,
            'ktp_amount' => $this->ktp_amount,
            'reminder' => $this->reminder,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'ktp_title', $this->ktp_title])
            ->andFilterWhere(['like', 'ktp_research', $this->ktp_research])
            ->andFilterWhere(['like', 'ktp_community', $this->ktp_community])
            ->andFilterWhere(['like', 'ktp_source', $this->ktp_source])
            ->andFilterWhere(['like', 'ktp_description', $this->ktp_description])
            ->andFilterWhere(['like', 'ktp_file', $this->ktp_file]);

        return $dataProvider;
    }
}
