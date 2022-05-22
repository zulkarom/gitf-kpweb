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
        $this->load($params);

        $query = Document::find()->where([
            'type_id' => $this->type_id
        ]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100
            ]
        ]);

        if (! $this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'identifier' => $this->identifier
        ]);

        $query->andFilterWhere([
            'like',
            'participant_name',
            $this->participant_name
        ]);

        return $dataProvider;
    }
}
