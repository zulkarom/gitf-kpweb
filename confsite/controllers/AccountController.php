<?php
namespace confsite\controllers;

use Yii;
use yii\web\NotFoundHttpException;
use confsite\models\LoginForm;
use confsite\models\NewUserForm;
use confsite\models\SignInForm;
use yii\widgets\ActiveForm;
use yii\web\Response;
use backend\modules\conference\models\Conference;
use yii\web\Controller;




/**
 * Site controller
 */
class AccountController extends Controller
{
   /*  public $layout = 'system';

    public function actionIndex($confurl=null)
    {
        $conf = $this->findConferenceByUrl($confurl);
        if (!\Yii::$app->user->isGuest) {
            return $this->redirect(['/site/member', 'confurl' => $confurl]);
        }
        
        $model = new NewUserForm();
        // $model->scenario = 'register';
        if (Yii::$app->request->isAjax) {
            $model->load($_POST);
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
            
        }else if ($model->load(Yii::$app->request->post()) && $model->signup($conf)) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for email verification.');
            return $this->refresh();
        }
        
        
        $modelLogin = new SignInForm();
        // $modelLogin->scenario = 'login';
        
        if ($modelLogin->load(Yii::$app->request->post()) && $modelLogin->login()){
            return $this->redirect(['/site/home', 'confurl' => $confurl]);
        }
        
        
        return $this->render('login', [
            'model' => $model,
            'modelLogin' => $modelLogin,
            'conf' => $conf
        ]); */
		
    }

    protected function findConferenceByUrl($url)
    {
        if (($model = Conference::findOne(['conf_url' => $url])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	

	
}
