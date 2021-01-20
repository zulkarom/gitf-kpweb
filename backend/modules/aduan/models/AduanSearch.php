<?php

namespace backend\modules\aduan\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\aduan\models\Aduan;

/**
 * AduanSearch represents the model behind the search form of `backend\modules\aduan\models\Aduan`.
 */
class AduanSearch extends Aduan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'declaration'], 'integer'],
            [['name', 'nric', 'address', 'email', 'phone', 'topic', 'title', 'aduan', 'upload_url', 'captcha'], 'safe'],
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
        $query = Aduan::find();

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
            'declaration' => $this->declaration,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'nric', $this->nric])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'topic', $this->topic])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'aduan', $this->aduan])
            ->andFilterWhere(['like', 'upload_url', $this->upload_url])
            ->andFilterWhere(['like', 'captcha', $this->captcha]);

        return $dataProvider;
    }
}
