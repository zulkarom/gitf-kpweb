<?php

namespace backend\modules\ticket\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class TicketSearch extends Ticket
{
    public function rules()
    {
        return [
            [['id', 'category_id', 'priority', 'status'], 'integer'],
            [['title', 'created_by', 'assigned_to'], 'safe'],
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params, $createdBy = null, $assignedTo = null)
    {
        $query = static::find()->joinWith(['creator c', 'assignee a']);

        if ($createdBy !== null) {
            $query->andWhere(['created_by' => $createdBy]);
        }

        if ($assignedTo !== null) {
            $query->andWhere(['assigned_to' => $assignedTo]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['created_at' => SORT_DESC],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
            'priority' => $this->priority,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        // Filter by creator / assignee fullname using the string entered in created_by / assigned_to filters
        $query->andFilterWhere(['like', 'c.fullname', $this->created_by]);
        $query->andFilterWhere(['like', 'a.fullname', $this->assigned_to]);

        return $dataProvider;
    }
}
