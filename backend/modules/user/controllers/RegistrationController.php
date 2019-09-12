<?php

namespace  backend\modules\user\controllers;

use dektrium\user\models\RegistrationForm;
use dektrium\user\controllers\RegistrationController as BaseRegistrationController;

class RegistrationController extends BaseRegistrationController
{
    /**
     * Displays the registration page.
     * After successful registration if enableConfirmation is enabled shows info message otherwise
     * redirects to home page.
     *
     * @return string
     * @throws \yii\web\HttpException
     */
    public function actionRegister()
    {
		
	}
	
	public function actionResend(){

	}
	
	public function actionConfirm($id, $code){

	} 

    
}
