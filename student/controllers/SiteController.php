<?php
namespace student\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use student\models\LoginForm;



/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'register'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['index', 'logout', 'member', 'error'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],

        ];
    }


    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }
    
    public function beforeAction($action) {
        if (parent::beforeAction($action)) {
            // change layout for error action
            if ($action->id=='error') $this->layout ='error';
            return true;
        } else {
            return false;
        }
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {

       return $this->render('index');
        
    }
	
	
	
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            //return $this->goBack();
            return $this->goHome();
        } else {
            $this->layout = "//main-login";
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
	

    public function actionLogout()
    {
        Yii::$app->user->logout();
        
        return $this->redirect(['/site/login']);
    }
	


	

	
}
