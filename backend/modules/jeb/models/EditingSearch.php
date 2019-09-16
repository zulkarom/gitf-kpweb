<?php

namespace backend\modules\jeb\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Todo;

/**
 * ArticleSearch represents the model behind the search form of `common\models\Article`.
 */
class EditingSearch extends Article
{
	public $str_search;
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
		
		
        return [
		
            [['str_search'], 'string'],
			
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
        $query = Article::find();
		$query->joinWith('articleReviewers');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
        ]);
		
		$query->orFilterWhere([
			'jeb_article.status' => 'ArticleWorkflow/ja-galley-proof',
			'assistant_editor' => Yii::$app->user->identity->id
        ]);
		
		$query->orFilterWhere([
			'jeb_article.status' => 'ArticleWorkflow/ka-finalise',
			'assistant_editor' => Yii::$app->user->identity->id
        ]);
		//assign-proof-reader
		
		if(Todo::can('jeb-managing-editor') or Todo::can('jeb-editor-in-chief')){
			$query->orFilterWhere([
				'jeb_article.status' => 'ArticleWorkflow/ja-galley-proof'
			]);
			
			$query->orFilterWhere([
				'jeb_article.status' => 'ArticleWorkflow/ka-assign-proof-reader'
			]);
			
			$query->orFilterWhere([
				'jeb_article.status' => 'ArticleWorkflow/la-proofread'
			]);
			
			$query->orFilterWhere([
				'jeb_article.status' => 'ArticleWorkflow/ma-finalise'
			]);
			
			$query->orFilterWhere([
				'jeb_article.status' => 'ArticleWorkflow/oa-camera-ready'
			]);
			
		}
		
		if(Todo::can('jeb-proof-reader')){
			
			$query->orFilterWhere([
				'proof_reader' => Yii::$app->user->identity->id
			]);
			
		}
		

        $query->andFilterWhere(['like', 'title', $this->str_search])
            ->andFilterWhere(['like', 'keyword', $this->str_search])
            ->andFilterWhere(['like', 'abstract',$this->str_search]);

        return $dataProvider;
    }
}
