<?php
namespace backend\modules\ecert\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * DocumentSearch represents the model behind the search form of `backend\modules\ecert\models\Document`.
 */
class DocumentSearch extends Document
{

    /**
     *
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [
                [
                    'id',
                    'downloaded'
                ],
                'integer'
            ],
            [
                [
                    'identifier'
                ],
                'string'
            ],
            [
                [
                    'participant_name',
                    'field1',
                    'field2',
                    'field3',
                    'field4',
                    'field5'
                ],
                'safe'
            ]
        ];
    }

    /**
     *
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
        $query = Document::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        $this->load($params);

        if (! $this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'identifier' => $this->identifier,
            'downloaded' => $this->downloaded
        ]);

        $query->andFilterWhere([
            'like',
            'participant_name',
            $this->participant_name
        ])
            ->andFilterWhere([
            'like',
            'field1',
            $this->field1
        ])
            ->andFilterWhere([
            'like',
            'field2',
            $this->field2
        ])
            ->andFilterWhere([
            'like',
            'field3',
            $this->field3
        ])
            ->andFilterWhere([
            'like',
            'field4',
            $this->field4
        ])
            ->andFilterWhere([
            'like',
            'field5',
            $this->field5
        ]);

        return $dataProvider;
    }
}
