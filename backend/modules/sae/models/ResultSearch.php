<?php

namespace backend\modules\sae\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\modules\sae\models\Candidate;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
/**
 * ResultSearch represents the model behind the search form of `backend\models\Candidate`.
 */
class ResultSearch extends Candidate
{
    public $others = null;
    public $bat_id;
    public $limit;
    public $point_min;
    public $point_min_total;
    public $domainOrder;
    public $column1;
    public $domain;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['status', 'can_batch', 'bat_id', 'limit'], 'integer'],
            [['column1'], 'string', 'max' => 225],
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

        $colum = ["c.id", "c.username", "c.can_name", "b.bat_text" ,
        "a.answer_status", "a.overall_status", "a.finished_at", 
        'a.column1', 'a.column2', 'a.column3', 'a.column4'];
        $c=1;
		$calc_all = '';
		$this->domain = [];
		foreach($result as $row){
			if($row->grade_cat <> 99){
				if($c==1){$comma="";}else{$comma=", ";}
				$str = "";
				$quest = Question::find()->where(['grade_cat' => $row->grade_cat])->all();
				
				$i=1;
				$jumq = count($quest);
				foreach($quest as $rq){
					if($i == $jumq){$plus = "";}else{$plus=" + ";}
					$str .= "IF(q".$rq->que_id ." > 0,1,0) ". $plus ;
				$i++;
				}
				
				$str .= " as c". $row->grade_cat;
				$this->domain[] = $row->grade_cat;
				$c++;  
				$colum[] = $str; 
			}
        }
		
		$quest_all = Question::find()->all();
		$x=1;
		$jums = count($quest_all);
		foreach($quest_all as $rq){
			$plus_all = $x == $jums ? '' : '+';
			$calc_all .= "IF(q".$rq->que_id ." > 0,1,0) ". $plus_all ;
		$x++;
		}
		$colum[] = $calc_all . ' as total';
		
		$str_order = "";
		$c=1;
        foreach($result as $row){
        if($c==1){$comma="";}else{$comma=", ";}
			if($row->grade_cat == 99){
				$str_order .= $comma." total DESC";
			}else{
				$str_order .= $comma."c". $row->grade_cat." DESC";
			}
        $c++;  
        }
        $this->domainOrder = $str_order;
		
        return $colum;
    }

    public function search()
    {
        //print_r($params);die();

        // SELECT answer_status AS c1, overall_status AS c2, column1 FROM `psy_answers` WHERE column1 IN("PTPTN", "JABATAN DASAR") ORDER BY c1 ASC, c2 ASC, FIELD(column1, "PTPTN", "JABATAN DASAR"),  FIELD(column2, "32", "33")
        
        $order = ''; //// in case takde selection domain
        
        $select = $this->columResultAnswers();
        $order .= $this->domainOrder; //// .= append string order
        $comma = $this->domainOrder ? ',' : ''; 
        //$order .= $comma; //// klu ada domain order baru start dgn comma

        $array_filter = [];
        $colum = Demographic::find()
        ->select('DISTINCT(column_id)')
        ->where(['bat_id' => $this->bat_id])
        ->all();
        
        if($colum){ //// kena pastikan ada dulu baru foreach
            foreach($colum as $i => $col){
                $demos = Demographic::find()
                ->where(['bat_id' => $this->bat_id, 'column_id' => $col->column_id])
                ->all();
                
                $array_filter[$col->column_id] = ArrayHelper::map($demos, 'id', 'demo_value'); 
                
            }
        }
        
        if($array_filter){ //////// string order field kat sini
			$first_comma = $comma;
            $i = 1;
            foreach($array_filter as $key => $val){
				$comma = $i == 1 ? $first_comma : ',';
                $order .= $comma . 'FIELD(a.column'.$key.', '. $this->arrayToStr($val) .')';
            $i++;
            }
        }
        

        //echo $this->limit;
        //die();
        $query = Answer::find()
        ->alias('a')
        ->joinWith(['batch b', 'candidate c'])
        ->select($select)
        ->andWhere(['b.id' => $this->bat_id, 'a.answer_status' => 3]);
        if($this->point_min){
            $point = $this->point_min;
            if($this->domain){
                foreach($this->domain as $c){
                    $query = $query->andHaving(['>=', 'c'.$c, $point]);
                }
            }
      
        }
        if($this->point_min_total){
            $point = $this->point_min_total;
            $query = $query->andHaving(['>=', 'total', $point]);
        }
        $query = $query->limit($this->limit)
		;
        $total = count($query->all());
        //echo $total;die();
		if($order){
			$query->orderBy( new Expression($order)); /// guna string biasa
		}
        

        if($array_filter){
            foreach($array_filter as $key => $val){
                $query->andWhere(['a.column' . $key => $val]);

            }
        }
        
        // echo $this->domainOrder;
        // die();
        // add conditions that should always apply here
    
       $limit = 100;
        if($this->limit){
            if($limit <= 100){
                $limit = $this->limit;
            }
        } 
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $limit,
            ],
        ]);
        
        $dataProvider->setTotalCount($total);

       // $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'can_batch' => $this->can_batch,
        ]);


        $query->andFilterWhere(['or',
            ['like', 'username', $this->others],
            ['like', 'can_name', $this->others]
        ]);
            

        return $dataProvider;
    }
    
    private function arrayToStr($array){
        if($array){
            $str = '';
            $i = 0;
            foreach($array as $a){
                $comma = $i == 0 ? '': ',';
                $str .= $comma .  '"' . $a  . '"'; //// letak double quote
                $i++;
            }
            return $str;
        }else{
            return '';
        }
    }
}
