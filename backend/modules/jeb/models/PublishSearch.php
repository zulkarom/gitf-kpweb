<?php

namespace backend\modules\jeb\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Todo;

/**
 * ArticleSearch represents the model behind the search form of `common\models\Article`.
 */
class PublishSearch extends Article
{
	public $str_search;
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
		
		
        return [
		
            [['title'], 'string'],
			
			[['journal_id'], 'integer'],
			
            [['str_search'], 'safe'],
			
			
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
        $query = Article::find()->orderBy('status ASC, journal_id DESC');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
			'pagination' => [
                'pageSize' => 30,
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
            'journal_id' => $this->journal_id,
			'status' => ['ArticleWorkflow/pa-assign-journal', 'ArticleWorkflow/qa-publish']
        ]);
		
		
		/* if(Todo::can('jeb-managing-editor')){
			$query->orFilterWhere([
				'status' => 'ArticleWorkflow/pa-journal'
			]);
		} */
		
		

        $query->andFilterWhere(['like', 'title', $this->title]);
		

        return $dataProvider;
    }
}
