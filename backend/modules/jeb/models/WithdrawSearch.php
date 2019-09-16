<?php

namespace backend\modules\jeb\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Todo;

/**
 * ArticleSearch represents the model behind the search form of `common\models\Article`.
 */
class WithdrawSearch extends Article
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
		
		
		if(Todo::can('jeb-managing-editor') or Todo::can('jeb-editor-in-chief')){
			$query->orFilterWhere([
				'status' => 'ArticleWorkflow/sa-withdraw-request'
			]);
			$query->orFilterWhere([
				'status' => 'ArticleWorkflow/ta-withdraw'
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
