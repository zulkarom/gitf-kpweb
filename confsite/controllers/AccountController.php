<?php
namespace confsite\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use confsite\models\LoginForm;
use confsite\models\NewUserForm;
use confsite\models\SignInForm;



/**
 * Site controller
 */
class AccountController extends SiteController
{
    public $layout = 'system';

    public function actionIndex($confurl=null)
    {
        if (!\Yii::$app->user->isGuest) {
            //$this->goHome();
            return $this->user_redirect();
        }
        
        $model = new NewUserForm();
        // $model->scenario = 'register';
        
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for email verification.');
            return $this->refresh();
        }
        
        
        $modelLogin = new SignInForm();
        // $modelLogin->scenario = 'login';
        
        if ($modelLogin->load(Yii::$app->request->post()) && $modelLogin->login()){
            return $this->redirect(['home']);
        }
        
        
        return $this->render('login', [
            'model' => $model,
            'modelLogin' => $modelLogin,
            'confurl' => $confurl
        ]);
		
    }
	
	

	
}
