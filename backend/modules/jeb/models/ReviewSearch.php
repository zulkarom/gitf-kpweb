<?php

namespace backend\modules\jeb\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Todo;

/**
 * ArticleSearch represents the model behind the search form of `common\models\Article`.
 */
class ReviewSearch extends Article
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
		$access = false;
        $query = Article::find()->orderBy('status ASC');
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
        
		
		if(Todo::can('jeb-reviewer')){
			$query->orFilterWhere([
			'jeb_article_reviewer.user_id' => Yii::$app->user->identity->id ,
			'jeb_article_reviewer.status' => [0, 10, 20]
			
        ]);
		
		$access = true;
		}
		
		
		
		
		if(Todo::can('jeb-managing-editor')){
			$query->orFilterWhere([
				'jeb_article.status' => 'ArticleWorkflow/ea-recommend'
			]);
			$query->orFilterWhere([
				'jeb_article.status' => 'ArticleWorkflow/da-review'
			]);
			
			$query->orFilterWhere([
				'jeb_article.status' => 'ArticleWorkflow/ba-pre-evaluate'
			]);
			
			$query->orFilterWhere([
				'jeb_article.status' => 'ArticleWorkflow/ca-assign-reviewer'
			]);
			
			$access = true;
		}
		
		
		//for associate_editor
		$query->orFilterWhere([
			'jeb_article.status' => 'ArticleWorkflow/ca-assign-reviewer',
			'associate_editor' => Yii::$app->user->identity->id
        ]);
		
		if(Todo::can('jeb-managing-editor') or Todo::can('jeb-editor-in-chief')){
			$query->orFilterWhere([
				'jeb_article.status' => 'ArticleWorkflow/fa-evaluate'
			]);
			$query->orFilterWhere([
				'jeb_article.status' => 'ArticleWorkflow/ga-response'
			]);
			$query->orFilterWhere([
				'jeb_article.status' => 'ArticleWorkflow/ha-correction'
			]);
			$query->orFilterWhere([
				'jeb_article.status' => 'ArticleWorkflow/ia-post-evaluate'
			]);
			
			
			$access = true;
		}
		
		if(Todo::can('jeb-associate-editor')){
			$query->orFilterWhere([
				'associate_editor' => Yii::$app->user->identity->id
			]);
			$access = true;
		}
		
		
		if(!$access){
			$query->andFilterWhere([
            'jeb_article.id' => 'abc',
        ]);
		}
		

        $query->andFilterWhere(['like', 'title', $this->str_search])
            ->andFilterWhere(['like', 'keyword', $this->str_search])
            ->andFilterWhere(['like', 'abstract',$this->str_search]);

        return $dataProvider;
    }
}
