<?php 

namespace backend\modules\teachingLoad\models;

class Common {
	
	public static function progress($percentage){
		$color = '';
		$width = 30;
		$active = 'active';
		$striped = 'progress-bar-striped';
		if($percentage <= 0.2){
			$width = 20;
			$color = 'progress-bar-danger';
		}else if($percentage <= 0.3){
			$width = $percentage * 100;
			$color = 'progress-bar-danger';
		}else if($percentage <= 0.6){
			$width = $percentage * 100;
			$color = 'progress-bar-warning';
		}else if($percentage <= 0.8){
			$width = $percentage * 100;
			$color = 'progress-bar-info';
		}else if($percentage > 0.8){
			$width = $percentage * 100;
			$color = 'progress-bar-success';
		}
		
		if($percentage >= 1){
			$active = '';
			$striped = '';
		}
		$per = number_format($percentage * 100,0) . '%';
		$html = '<div class="progress">
  <div class="progress-bar '.$color.' '.$striped.' '.$active.'" role="progressbar"
  aria-valuenow="'.(int)$width.'" aria-valuemin="0" aria-valuemax="100" style="width:'. (int)$width.'%">
    '. $per .'
  </div>
</div>';

	return $html;
	
	}
}



?>