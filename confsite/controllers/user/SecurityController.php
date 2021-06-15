<?php

namespace confsite\controllers\user;


use dektrium\user\controllers\SecurityController as BaseSecurityController;
use dektrium\user\models\LoginForm;
use phpDocumentor\Reflection\PseudoTypes\False_;

class SecurityController extends BaseSecurityController
{
   public function actionLogin()
    {
		$url = \Yii::$app->user->returnUrl;
		if (strpos($url, '?') !== false) {
			$str = explode('?', $url);
			if (strpos($str[1], '&') !== false) {
			    //echo 'ada &' . $str[1];die();
			    $and = explode('&', $str[1]);
			    //echo count($and);
			    $url = $this->processAnd($and);
			}else{
			    $url = $this->processEqual($str[1]);
			}
		}
		//die();
		if($url){
		    return $this->redirect(['/site/login', 'confurl' => $url]);
		}else{
		    return $this->redirect(['/site/index']);
		}
		//
	}
	
	private function processAnd($arr){
	    if($arr){
	        foreach($arr as $a){
	            echo $a;
	            if (strpos($a, '=') !== false) {
	                if($this->processEqual($a)){
	                    return $this->processEqual($a);
	                }

	            }
	        }
	    }
	    
	    return false;
	}
	
	private function processEqual($str){
	    //echo $str;
	    if (strpos($str, '=') !== false) {
	        $arr = explode('=', $str);
	           if($arr[0] == 'confurl'){
	               return $arr[1];
    	        }
	        
	    }
	    
	    return false;
	}
}
