<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\website\models\Event;
use yii\db\Expression;

/**
 * EventSearch represents the model behind the search form of `backend\modules\website\models\Event`.
 */
class EventSearch extends Event
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'publish_promo', 'publish_report', 'created_by'], 'integer'],
            [['name', 'date_start', 'date_end', 'time_start', 'time_end', 'city', 'venue', 'register_link', 'intro_promo', 'promoimg_file', 'newsimg_file', 'report_1', 'report_2', 'imagetop_file', 'imagemiddle_file', 'imagebottom_file', 'updated_at', 'created_at', 'target_participant', 'objective', 'register_deadline', 'contact_pic', 'brochure_file', 'speaker'], 'safe'],
            [['fee'], 'number'],
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
        $query = Event::find()
		->where(['publish_promo' => 1])
		->andWhere(['>=', 'date_start', new Expression('NOW()')])
		->orderBy('date_start ASC');

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
            'date_start' => $this->date_start,
            'date_end' => $this->date_end,
            'time_start' => $this->time_start,
            'time_end' => $this->time_end,
            'publish_promo' => $this->publish_promo,
            'publish_report' => $this->publish_report,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
            'fee' => $this->fee,
            'register_deadline' => $this->register_deadline,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'venue', $this->venue])
            ->andFilterWhere(['like', 'register_link', $this->register_link])
            ->andFilterWhere(['like', 'intro_promo', $this->intro_promo])
            ->andFilterWhere(['like', 'promoimg_file', $this->promoimg_file])
            ->andFilterWhere(['like', 'newsimg_file', $this->newsimg_file])
            ->andFilterWhere(['like', 'report_1', $this->report_1])
            ->andFilterWhere(['like', 'report_2', $this->report_2])
            ->andFilterWhere(['like', 'imagetop_file', $this->imagetop_file])
            ->andFilterWhere(['like', 'imagemiddle_file', $this->imagemiddle_file])
            ->andFilterWhere(['like', 'imagebottom_file', $this->imagebottom_file])
            ->andFilterWhere(['like', 'target_participant', $this->target_participant])
            ->andFilterWhere(['like', 'objective', $this->objective])
            ->andFilterWhere(['like', 'contact_pic', $this->contact_pic])
            ->andFilterWhere(['like', 'brochure_file', $this->brochure_file])
            ->andFilterWhere(['like', 'speaker', $this->speaker]);

        return $dataProvider;
    }
}
