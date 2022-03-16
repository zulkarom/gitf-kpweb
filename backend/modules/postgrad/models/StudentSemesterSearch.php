<?php

namespace backend\modules\postgrad\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\postgrad\models\StudentSemester;

/**
 * StudentSemesterSearch represents the model behind the search form of `backend\modules\postgrad\models\StudentSemester`.
 */
class StudentSemesterSearch extends StudentSemester
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'semester_id', 'status'], 'integer'],
            [['date_register', 'fee_paid_at'], 'safe'],
            [['fee_amount'], 'number'],
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
        $query = StudentSemester::find();

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
            'semester_id' => $this->semester_id,
            'date_register' => $this->date_register,
            'status' => $this->status,
            'fee_amount' => $this->fee_amount,
            'fee_paid_at' => $this->fee_paid_at,
        ]);

        return $dataProvider;
    }
}
