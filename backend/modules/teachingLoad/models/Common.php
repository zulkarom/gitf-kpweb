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
		}else if($percentage <= 0.99){
			$width = $percentage * 100;
			$color = 'progress-bar-info';
		}else if($percentage >= 1){
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
	
	public static function withoutRounding($number, $total_decimals) {
		$number = (string)$number;
		if($number === '') {
			$number = '0';
		}
		if(strpos($number, '.') === false) {
			$number .= '.';
		}
		$number_arr = explode('.', $number);

		$decimals = substr($number_arr[1], 0, $total_decimals);
		if($decimals === false) {
			$decimals = '0';
		}

		$return = '';
		if($total_decimals == 0) {
			$return = $number_arr[0];
		} else {
			if(strlen($decimals) < $total_decimals) {
				$decimals = str_pad($decimals, $total_decimals, '0', STR_PAD_RIGHT);
			}
			$return = $number_arr[0] . '.' . $decimals;
		}
		return $return;
	}
}



?>