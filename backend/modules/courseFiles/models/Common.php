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
}
