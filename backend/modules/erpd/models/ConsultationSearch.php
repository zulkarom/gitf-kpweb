<?php

namespace backend\modules\erpd\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\erpd\models\Consultation;

/**
 * ConsultationSearch represents the model behind the search form of `backend\modules\erpd\models\Consultation`.
 */
class ConsultationSearch extends Consultation
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'csl_staff', 'csl_level'], 'integer'],
            [['csl_title', 'csl_funder', 'date_start', 'date_end', 'csl_file'], 'safe'],
            [['csl_amount'], 'number'],
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
        $query = Consultation::find();

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
            'csl_staff' => $this->csl_staff,
            'csl_amount' => $this->csl_amount,
            'csl_level' => $this->csl_level,
            'date_start' => $this->date_start,
            'date_end' => $this->date_end,
        ]);

        $query->andFilterWhere(['like', 'csl_title', $this->csl_title])
            ->andFilterWhere(['like', 'csl_funder', $this->csl_funder])
            ->andFilterWhere(['like', 'csl_file', $this->csl_file]);

        return $dataProvider;
    }
}
