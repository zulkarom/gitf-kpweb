<?php

namespace backend\modules\erpd\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\erpd\models\KnowledgeTransfer;

/**
 * KnowledgeTransferSearch represents the model behind the search form of `backend\modules\erpd\models\KnowledgeTransfer`.
 */
class KnowledgeTransferSearch extends KnowledgeTransfer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'staff_id', 'reminder'], 'integer'],
            [['ktp_title', 'date_start', 'date_end', 'ktp_research', 'ktp_community', 'ktp_source', 'ktp_description', 'ktp_file', 'created_at', 'modified_at'], 'safe'],
            [['ktp_amount'], 'number'],
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
        $query = KnowledgeTransfer::find();
		$query->joinWith(['members']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'sort'=> ['defaultOrder' => ['status'=>SORT_ASC, 'date_start' =>SORT_DESC]],
			'pagination' => [
					'pageSize' => 100,
				],
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
			'rp_knowledge_transfer_member.staff_id' => Yii::$app->user->identity->staff->id,

        ]);

        $query->andFilterWhere(['like', 'ktp_title', $this->ktp_title]);

        return $dataProvider;
    }
}
