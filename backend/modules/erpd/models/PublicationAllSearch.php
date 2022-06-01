<?php
namespace backend\modules\erpd\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PublicationSearch represents the model behind the search form of `backend\modules\erpd\models\Publication`.
 */
class PublicationAllSearch extends Publication
{

    /**
     *
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'pub_type',
                    'pub_year',
                    'status'
                ],
                'integer'
            ],

            [
                [
                    'pub_title'
                ],
                'string'
            ]
        ];
    }

    /**
     *
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
        $query = Publication::find()->where([
            '<>',
            'status',
            0
        ]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'status' => SORT_ASC,
                    'pub_year' => SORT_DESC,
                    'pub_type' => SORT_ASC
                ]
            ],
            'pagination' => [
                'pageSize' => 50
            ]
        ]);

        $this->load($params);

        if (! $this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'pub_type' => $this->pub_type,
            'pub_year' => $this->pub_year,
            'status' => $this->status
        ]);

        $query->andFilterWhere([
            'like',
            'pub_title',
            $this->pub_title
        ]);

        return $dataProvider;
    }
}
