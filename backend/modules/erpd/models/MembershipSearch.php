<?php

namespace backend\modules\erpd\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\erpd\models\Membership;

/**
 * MembershipSearch represents the model behind the search form of `backend\modules\erpd\models\Membership`.
 */
class MembershipSearch extends Membership
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'msp_staff', 'msp_level'], 'integer'],
            [['msp_body', 'msp_type', 'date_start', 'date_end', 'msp_file'], 'safe'],
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
        $query = Membership::find();

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
            'msp_staff' => Yii::$app->user->identity->staff->id,
            'msp_level' => $this->msp_level,
            'date_start' => $this->date_start,
            'date_end' => $this->date_end,
        ]);

        $query->andFilterWhere(['like', 'msp_body', $this->msp_body])
            ->andFilterWhere(['like', 'msp_type', $this->msp_type])
            ->andFilterWhere(['like', 'msp_file', $this->msp_file]);

        return $dataProvider;
    }
}
