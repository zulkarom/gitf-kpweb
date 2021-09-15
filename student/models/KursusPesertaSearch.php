<?php

namespace student\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\postgrad\models\KursusPeserta;

/**
 * KursusPesertaSearch represents the model behind the search form of `backend\modules\postgrad\models\KursusPeserta`.
 */
class KursusPesertaSearch extends KursusPeserta
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'anjur_id', 'status', 'is_paid', 'payment_method'], 'integer'],
            [['submitted_at', 'paid_at'], 'safe'],
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
        $query = KursusPeserta::find()
        ->where(['user_id' => Yii::$app->user->identity->id, 'user_type' => 4]);

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
            'user_id' => $this->user_id,
            'anjur_id' => $this->anjur_id,
            'status' => $this->status,
            'submitted_at' => $this->submitted_at,
            'paid_at' => $this->paid_at,
            'is_paid' => $this->is_paid,
            'payment_method' => $this->payment_method,
        ]);

        return $dataProvider;
    }
}
