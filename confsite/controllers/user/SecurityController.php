<?php

namespace confsite\controllers\user;


use dektrium\user\controllers\SecurityController as BaseSecurityController;
use dektrium\user\models\LoginForm;

class SecurityController extends BaseSecurityController
{
   public function actionLogin($confurl)
    {
		$this->layout = "//main-login";
		
		if (!\Yii::$app->user->isGuest) {
            $this->goHome();
        }

        /** @var LoginForm $model */
        $model = \Yii::createObject(LoginForm::className());
        $event = $this->getFormEvent($model);

        $this->performAjaxValidation($model);

        $this->trigger(self::EVENT_BEFORE_LOGIN, $event);

        if ($model->load(\Yii::$app->getRequest()->post()) && $model->login()) {
            $this->trigger(self::EVENT_AFTER_LOGIN, $event);
            return $this->goHome();
        }

        return $this->render('login', [
            'model'  => $model,
            'module' => $this->module,
        ]);
	}
}
