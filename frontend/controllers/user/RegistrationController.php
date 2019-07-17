<?php

namespace frontend\controllers\user;

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
		//$this->layout = "//main-login";
		//\Yii::$app->session->addFlash('success', "Data Successful");
		
		
		if (!$this->module->enableRegistration) {
            throw new NotFoundHttpException();
        }

        /** @var RegistrationForm $model */
        $model = \Yii::createObject(RegistrationForm::className());
        $event = $this->getFormEvent($model);

        $this->trigger(self::EVENT_BEFORE_REGISTER, $event);

        $this->performAjaxValidation($model);

        if ($model->load(\Yii::$app->request->post())) {
			$model->username = $model->email;
			if($model->register()){
				$this->trigger(self::EVENT_AFTER_REGISTER, $event);

				return $this->render('/message', [
					'title'  => \Yii::t('user', 'Your account has been created'),
					'module' => $this->module,
				]);
			}else{
				//print_r($model->getErrors());
			}
			
            
        }

        return $this->render('register', [
            'model'  => $model,
            'module' => $this->module,
        ]);
	}
	
	/* public function actionResend(){
		$this->layout = "//main-login";
		return parent::actionResend();
	}
	
	public function actionConfirm($id, $code){
		$this->layout = "//main-login";
		return parent::actionConfirm($id, $code);
	} */

    
}
