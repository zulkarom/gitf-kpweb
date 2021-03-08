<?php

namespace backend\modules\courseFiles\models;

use Yii;

class Common
{
   public static function pTick($boo = true){
	   if($boo){
		   return '<span style="color:green;font-size:16px"><i class="fa fa-check"></i></span>';
	   }else{
		   return '<span style="color:red;font-size:16px"><i class="fa fa-warning"></i></span>';
	   }
   }
}
