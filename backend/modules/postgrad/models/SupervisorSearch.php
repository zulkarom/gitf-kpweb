<?php

namespace backend\modules\postgrad\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\postgrad\models\Supervisor;

/**
 * SupervisorSearch represents the model behind the search form of `backend\modules\postgrad\models\Supervisor`.
 */
class SupervisorSearch extends Supervisor
{
    
    public $svName;
    public $svFieldsString;
    
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['is_internal'], 'integer'],
            [['svName', 'svFieldsString'], 'string'],
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
        $query = Supervisor::find()->alias('a')
        ->joinWith(['staff.user u', 'external x', 'svFields.field f']);

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
            'is_internal' => $this->is_internal
        ]);
        
        $query->andFilterWhere(['or',
            ['like', 'u.fullname', $this->svName],
            ['like', 'x.ex_name', $this->svName]
        ]);
        
        $query->andFilterWhere(
            ['like', 'f.field_name', $this->svFieldsString]
        );
        

        return $dataProvider;
    }
}
