<?php

namespace backend\modules\sae\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\sae\models\Candidate;

/**
 * CandidateSearch represents the model behind the search form of `backend\models\Candidate`.
 */
class CandidateSearch extends Candidate
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'status', 'can_batch', 'can_zone', 'answer_status', 'answer_status2', 'overall_status', 'question_last_saved', 'created_at', 'updated_at'], 'integer'],
            [['username', 'auth_key', 'password_hash', 'password_reset_token', 'email', 'can_name', 'department', 'answer_last_saved', 'answer_last_saved2', 'verification_token'], 'safe'],
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
        $query = Candidate::find()->where(['!=' ,'id', 1]);

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
            'status' => $this->status,
            'can_batch' => $this->can_batch,
            'can_zone' => $this->can_zone,
            // 'finished_at' => $this->finished_at,
            'answer_status' => $this->answer_status,
            'answer_status2' => $this->answer_status2,
            'overall_status' => $this->overall_status,
            'question_last_saved' => $this->question_last_saved,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'can_name', $this->can_name])
            ->andFilterWhere(['like', 'department', $this->department])
            ->andFilterWhere(['like', 'answer_last_saved', $this->answer_last_saved])
            ->andFilterWhere(['like', 'answer_last_saved2', $this->answer_last_saved2])
            ->andFilterWhere(['like', 'verification_token', $this->verification_token]);

        return $dataProvider;
    }
}
