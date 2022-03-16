<?php

namespace backend\modules\postgrad\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\postgrad\models\StudentSupervisor;

/**
 * StudentSupervisorSearch represents the model behind the search form of `backend\modules\postgrad\models\StudentSupervisor`.
 */
class StudentSupervisorSearch extends StudentSupervisor
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'supervisor_id'], 'integer'],
            [['appoint_at'], 'safe'],
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
        $query = StudentSupervisor::find();

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
            'supervisor_id' => $this->supervisor_id,
            'appoint_at' => $this->appoint_at,
        ]);

        return $dataProvider;
    }
}
