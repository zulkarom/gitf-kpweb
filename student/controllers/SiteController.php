<?php
namespace student\controllers;

use frontend\models\SignupForm;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\db\Expression;
use backend\modules\conference\models\Conference;
use backend\modules\conference\models\ConfRegistration;
use confsite\models\ConferenceSearch;
use confsite\models\LoginForm;
use common\models\UploadFile;



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
                        'actions' => ['login', 'index', 'error', 'register'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'member', 'error'],
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
        
        return $this->redirect(['/user/login']);
    }
	


	

	
}
