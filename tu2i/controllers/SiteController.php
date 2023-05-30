<?php

namespace tu2i\controllers;

use tu2i\models\ResendVerificationEmailForm;
use tu2i\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Session;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use tu2i\models\LoginForm;
use tu2i\models\PasswordResetRequestForm;
use tu2i\models\ResetPasswordForm;
use tu2i\models\SignupForm;
use tu2i\models\ContactForm;
use backend\modules\sae\models\Question;
use backend\modules\sae\models\Batch;
/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup', 'login'],
                'rules' => [
                    [
                        'actions' => ['signup', 'index', 'login', 'download'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'index', 'login'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {

        $this->layout = "//main-login";

        $model = new LoginForm();
        $model2 = new SignupForm();
        $openBatch = Batch::find()->where(['bat_show' => 1])->one();

        if(\Yii::$app->request->post('submit')) {
            $submit = \Yii::$app->request->post('submit');
            if($submit == 1){
                $model->scenario = 'login';
                /* if (!Yii::$app->user->isGuest) {
                    return $this->goHome();
                } */
                
                $session = Yii::$app->session;
               
                if ($model->load(Yii::$app->request->post()) && $model->login()) {
                   
                    $session->set('batch', $openBatch->id);
                    
                    //return $this->redirect(['test/update']);
                    return $this->redirect(['option/index']);
                }
                
            }elseif ($submit == 2) {
                // $model->scenario = 'register';
                if ($model2->load(Yii::$app->request->post()) && $model2->signup($openBatch->id)) {
                    $model->username = $model2->username;
                    $session = Yii::$app->session;
                    if($model->login()){
                        $session->set('batch', $openBatch->id);
                        Yii::$app->session->setFlash('success', 'Thank you for your registration.');
                        return $this->redirect(['/test/update']); 
                    }
                }
            }
        }

        return $this->render('login', [
            'model' => $model,
            'model2' => $model2,
			'batch' => $openBatch
        ]);
    }
    
    

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        return $this->redirect('index');
    /*     $this->layout = "//main-login";

        if(\Yii::$app->request->post('submit')) {
            $submit = \Yii::$app->request->post('submit');
            if($submit == 1){
                
            }elseif ($submit == 2) {
                
            }
        }


        //die();
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            //echo Yii::$app->user->identity->cl_name;
            //die();
            return $this->redirect(['index']);
            //return $this->goHome();
            
            //return $this->goBack();
            //return $this->goHome();
        } else {
            $this->layout = "//main-login";
            return $this->render('login', [
                'model' => $model,
            ]);
        } */
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


}
