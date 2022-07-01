<?php

namespace backend\modules\sae\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\sae\models\Candidate;

/**
 * ResultSearch represents the model behind the search form of `backend\models\Candidate`.
 */
class ResultSearch extends Candidate
{
    public $others = null;
    public $bat_id;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'can_batch', 'bat_id'], 'integer'],
            [['others'], 'string'],
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

    private function columResultAnswers(){
        $result = Domain::find()->where(['bat_id' => $this->bat_id])->all();
        $colum = ["a.id", "a.username", "a.can_name", "a.department", "a.can_zone", "a.can_batch",  "b.bat_text" ,
        "a.answer_status", "a.overall_status", "a.finished_at"];
        $c=1;
        
        foreach($result as $row){
        if($c==1){$comma="";}else{$comma=", ";}
            $str = "";
            $quest = Question::find()->where(['grade_cat' => $row->grade_cat])->all();
            $i=1;
            $jumq = count($quest);
            // echo $jumq;die();
            foreach($quest as $rq){
                if($i == $jumq){$plus = "";}else{$plus=" + ";}
                $str .= "IF(q".$rq->que_id ." > 0,1,0) ". $plus ;
            $i++;
            }
            $str .= " as c". $row->grade_cat;
        $c++;  
        $colum[] = $str; 
        }
        return $colum;
    }

    public function search($params)
    {
        // echo "<pre>";print_r($this->columResultAnswers());die();
        $query = Candidate::find()
        ->alias('a')
        ->select($this->columResultAnswers())
        ->joinWith(['batch b', 'answer c'])
        ->where(['!=' ,'a.id', 1])
        ->andWhere(['b.id' => $this->bat_id]);

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
            'status' => $this->status,
            'can_batch' => $this->can_batch,
        ]);


        $query->andFilterWhere(['or',
            ['like', 'username', $this->others],
            ['like', 'can_name', $this->others]
        ]);
            

        return $dataProvider;
    }
}
