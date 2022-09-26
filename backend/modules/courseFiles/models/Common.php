<?php

namespace backend\modules\courseFiles\models;

use Yii;

class Common
{
	public static $add_hour = 8;
	
   public static function pTick($boo = true){
	   if($boo){
		   return '<span style="color:green;font-size:16px"><i class="fa fa-check"></i></span>';
	   }else{
		   return '<span style="color:red;font-size:16px"><i class="fa fa-warning"></i></span>';
	   }
   }
   
   public static function currentTime(){
	   $time = time() + ( self::$add_hour * 60 * 60);
	return date('d M Y h:i A', $time);
   }
   
   public static function timeLeft($start, $end){
	   $time = time() + ( self::$add_hour * 60 * 60 );
	   $endtime = strtotime($end . ' 11:59:59');
	   if(self::isDue($end)){
		   $left = $endtime - $time;
			return date('d M Y h:i A', $left);
	   }else{
		   return '--';
	   }
	   
   }
   
   public static function isDue($date){
	   if($date){
		   $now = time() + ( self::$add_hour * 60 * 60 );
			$end = strtotime($date . ' 23:59:59');
			if($now > $end){
				return true;
			}
	   }
		
		
		return false;
	}
	
	public static function deadlineMessage($date){
		if($date){
			$time = strtotime($date . ' 23:59:59');
			if(self::isDue($date)){
				return '<span style="color:red">The system has been closed at '. date('d M Y h:i A', $time).'.</span>';
			}else{
				$time = strtotime($date . ' 23:59:59');
				return 'Kindly complete the task before ' . date('d M Y h:i A', $time);
			}
			
		}
		
	}

	public static function progress($percentage){
		$color = '';
		$width = 30;
		$active = 'active';
		$striped = 'progress-bar-striped';
		if($percentage <= 0.05){
			$width = 3;
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
		$html = '<div class="progress sm">
  <div class="progress-bar '.$color.' '.$striped.' '.$active.'" role="progressbar"
  aria-valuenow="'.(int)$width.'" aria-valuemin="0" aria-valuemax="100" style="width:'. (int)$width.'%">
  </div>
</div>';

	return $html;
	
	}
}
