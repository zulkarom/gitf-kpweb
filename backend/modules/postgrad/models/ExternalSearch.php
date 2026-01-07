<?php

namespace backend\modules\postgrad\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\postgrad\models\External;

/**
 * ExternalSearch represents the model behind the search form of `backend\modules\postgrad\models\External`.
 */
class ExternalSearch extends External
{
    public $svFieldsString;
    public $universityName;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at'], 'integer'],
            [['ex_name', 'university_id', 'svFieldsString', 'universityName'], 'safe'],
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
        $query = External::find()->alias('e')
            ->joinWith(['svFields.field f'])
            ->joinWith(['university uni']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // enable sorting by field name string
        $dataProvider->sort->attributes['svFieldsString'] = [
            'asc' => ['f.field_name' => SORT_ASC],
            'desc' => ['f.field_name' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['universityName'] = [
            'asc' => ['uni.uni_name' => SORT_ASC],
            'desc' => ['uni.uni_name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'e.id' => $this->id,
            'e.created_at' => $this->created_at,
            'e.updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'e.ex_name', $this->ex_name]);

        if (!empty($this->university_id)) {
            $query->andFilterWhere(['e.university_id' => $this->university_id]);
        }

        if (!empty($this->svFieldsString)) {
            $query->andFilterWhere(['like', 'f.field_name', $this->svFieldsString]);
        }

        if (!empty($this->universityName)) {
            $query->andFilterWhere(['like', 'uni.uni_name', $this->universityName]);
        }

        return $dataProvider;
    }
}
