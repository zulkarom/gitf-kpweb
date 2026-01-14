<?php

namespace backend\modules\grant\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class GrantSearch extends Grant
{
    public $researcher_linked;
    public $year;

    public function rules()
    {
        return [
            [['id', 'category_id', 'type_id', 'head_researcher_id', 'is_extended', 'year'], 'integer'],
            [['grant_title', 'project_code', 'head_researcher_name', 'date_start', 'date_end', 'researcher_linked'], 'safe'],
            [['amount'], 'number'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Grant::find()->alias('g');

        $query->leftJoin('pg_supervisor sv', 'sv.id = g.head_researcher_id');
        $query->leftJoin('staff st', 'st.id = sv.staff_id');
        $query->leftJoin('`user` u', 'u.id = st.user_id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100,
            ],
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
            ],
        ]);

        $dataProvider->sort->attributes['researcher_linked'] = [
            'asc' => ['u.fullname' => SORT_ASC],
            'desc' => ['u.fullname' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'g.id' => $this->id,
            'g.category_id' => $this->category_id,
            'g.type_id' => $this->type_id,
            'g.head_researcher_id' => $this->head_researcher_id,
            'g.amount' => $this->amount,
            'g.date_start' => $this->date_start,
            'g.date_end' => $this->date_end,
            'g.is_extended' => $this->is_extended,
        ]);

        if (!empty($this->year)) {
            $y = (int) $this->year;
            $yearStart = $y . '-01-01';
            $yearEnd = $y . '-12-31';
            $query->andWhere('g.date_start IS NOT NULL');
            $query->andWhere('g.date_start <= :yearEnd', [':yearEnd' => $yearEnd]);
            $query->andWhere('(g.date_end IS NULL OR g.date_end >= :yearStart)', [':yearStart' => $yearStart]);
        }

        $query->andFilterWhere(['like', 'g.grant_title', $this->grant_title])
            ->andFilterWhere(['like', 'g.project_code', $this->project_code])
            ->andFilterWhere(['like', 'g.head_researcher_name', $this->head_researcher_name])
            ->andFilterWhere(['like', 'u.fullname', $this->researcher_linked]);

        return $dataProvider;
    }
}
