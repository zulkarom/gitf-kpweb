<?php

namespace confsite\controllers\user;


use dektrium\user\controllers\SecurityController as BaseSecurityController;
use dektrium\user\models\LoginForm;

class SecurityController extends BaseSecurityController
{
   public function actionLogin()
    {
		$url = \Yii::$app->user->returnUrl;
		if (strpos($url, '?') !== false) {
			$str = explode('?', $url);
			
		}else{
			return $this->redirect(['site/index']);
		}
		//
	}
}
