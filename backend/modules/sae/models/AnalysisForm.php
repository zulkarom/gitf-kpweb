<?php

namespace backend\modules\sae\models;

use yii\base\Model;
use yii\helpers\ArrayHelper;

class AnalysisForm extends Model
{
    /**
     * @var integer
     */

    /**
     * @var array IDs of the favorite foods
     */
    public $domains;
    public $colum1;
	public $colum2;
	public $colum3;
	public $colum4;
	public $limit;
	public $point_min;
	public $point_min_total;
	
	public $aval_domains;
	public $sel_domains;
	
	public $aval_colum1;
	public $aval_colum2;
	public $aval_colum3;
	public $aval_colum4;
	
	public $sel_colum1;
	public $sel_colum2;
	public $sel_colum3;
	public $sel_colum4;
	
	public $batch;
	public $old_domains;
	
	public function __construct($batch, $reset){
		parent::__construct();

		$this->batch = $batch;
		$this->limit = $this->batch->result_limit;
		$this->point_min = $this->batch->point_min;
		$this->point_min_total = $this->batch->point_min_total;
		
		if($reset){
			$this->resetDomain($batch->id);
		}
		
		$this->sel_domains = Domain::find()->where(['bat_id' => $batch->id])->all();
			$selected_domain_arr = $this->domainMap($this->sel_domains,'grade_cat');
			$this->old_domains = $selected_domain_arr;
		$this->aval_domains = GradeCategory::find()->where(['not in', 'id', $selected_domain_arr])->orderBy('gcat_order ASC')->all();
	}
	
	public function rules()
    {
        return [
            
            [['domains', 'colum1', 'colum2', 'colum3', 'colum4'], 'string'],
            [['limit', 'point_min', 'point_min_total'], 'integer'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'point_min' => 'Minimum Point of Each Domain',
            'point_min_total' => 'Minimum Total Point'
        ];
    }
	
	private function resetDomain($batch){
		Domain::deleteAll(['bat_id' => $batch]);
		$grads = GradeCategory::allDomainsWithTotal();
		foreach($grads as $grad){
			$domain = new Domain;
			$domain->bat_id = $this->batch->id;
			$domain->grade_cat = $grad->id;
			$domain->save();
		}
		Demographic::deleteAll(['bat_id' => $batch]);
		$this->batch->result_limit = null;
		$this->batch->point_min = null;
		$this->batch->point_min_total = null;
		//echo $this->point_min;die();
		$this->batch->save();
	}
	
	public function saveLimit(){
		$batch = $this->batch->id;
		//save limit
		$this->batch->result_limit = $this->limit;
		$this->batch->point_min = $this->point_min;
		$this->batch->point_min_total = $this->point_min_total;
		//echo $this->point_min;die();
		return $this->batch->save();
	}
	
	public function saveDomain(){
		$batch = $this->batch->id;
		if($this->domains != json_encode($this->old_domains)){
			//save domain
			Domain::deleteAll(['bat_id' => $batch]);
			$new_domains = json_decode($this->domains);
			if($new_domains){
				foreach($new_domains as $d){
					$insert = new Domain;
					$insert->bat_id = $batch;
					$insert->grade_cat = $d;
					$insert->save();
				}
			}
		}
		return true;
	}
	
	public function saveDemographic(){
		
		$list = $this->demoList();
		if($list){
			foreach($list as $key => $val){
				Demographic::deleteAll(['bat_id' => $this->batch->id, 'column_id' => $key]);
				$col = 'colum' . $key;
				$col_arr = json_decode($this->$col);
				//print_r($col_arr);die();
				if ($col_arr) {
					foreach($col_arr as $c) {
						$ff = new Demographic();
						$ff->bat_id = $this->batch->id;
						$ff->column_id = $key;
						$ff->demo_value = $c;
						$ff->save();
					}
				}
			}
		}
	}
	
	public function saveAnalysis(){
		$this->saveLimit();
		$this->saveDomain();
		$this->saveDemographic();
		
	
		return true;
	}
	
	public function demoList(){
		$array = [];
		for($i=1;$i<=4;$i++){
			$col = 'column'. $i;
			if($this->batch->$col){
				$array[$i] = $this->batch->$col;
			}
		}
		return $array;
	}
	
	public function getSelectedArray($colum){
		$array = [];
        $demos = Demographic::find()->where(['bat_id' => $this->batch->id, 'column_id' => $colum])->all();
        foreach($demos as $dd) {
            $array[] = $dd->demo_value;
        }
		return $array;
	}
	
	public function getSelectedColumn($colum)
    {
        $array = $this->getSelectedArray($colum);
		if($array){
			$result = Answer::find()
			->select('DISTINCT(column'.$colum.'), COUNT(column'.$colum.') as total')
			->where(['bat_id' => $this->batch->id])
			->andWhere(['column'.$colum => $array])
			->groupBy('column'.$colum)
			->all();
			$items = $this->demoMap($result, $colum);
			return $items;
		}else{
			return $array;
		}
    }
	
	public function getAvailableColumn($colum)
    {
		$array = $this->getSelectedArray($colum);
		if(!$array){
			$array = ['1xxy00yzz1'];
		}
        $result = Answer::find()
        ->select('DISTINCT(column'.$colum.'), COUNT(column'.$colum.') as total')
        ->where(['bat_id' => $this->batch->id])
		->andWhere(['not in', 'column'.$colum, $array])
		->groupBy('column'.$colum)->all();
        $items = $this->demoMap($result, $colum);
        return $items;
    }
	
	
    public function demoMap($model, $colum){
		$array = [];
		if($model){
			foreach($model as $val){
				$col = 'column' . $colum;
				if($val->$col){
					$array[] = [$val->$col, $val->total];
				}
				
			}
		}
		return $array;
	}
	
	public function domainMap($model, $colum){
		$array = [];
		if($model){
			foreach($model as $val){
				$array[] = $val->$colum;
			}
		}
		return $array;
	}
	
}

?>