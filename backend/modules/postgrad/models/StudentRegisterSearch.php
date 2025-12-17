<?php

namespace backend\modules\postgrad\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\postgrad\models\StudentRegister;

class StudentRegisterSearch extends StudentRegister
{
    public function rules()
    {
        return [
            [['id', 'semester_id'], 'integer'],
            [['date_register', 'fee_paid_at'], 'safe'],
            [['fee_amount'], 'number'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = StudentRegister::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'semester_id' => $this->semester_id,
            'date_register' => $this->date_register,
            'fee_amount' => $this->fee_amount,
            'fee_paid_at' => $this->fee_paid_at,
        ]);

        return $dataProvider;
    }
}
