<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\Product;
use backend\models\Customer;
use backend\modules\staff\models\Staff;
use common\models\User;
use common\models\UserToken;

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
                        'actions' => ['login', 'error', 'my-error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'test', 'jeb-web', 'my-error'],
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
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index', [
			'user' => User::findOne(Yii::$app->user->identity->id),
		]);
    }
	
	

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
			
            return $this->goBack();
        } else {
            $this->layout = "//main-login";
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
	
	public function actionJebWeb()
    {
		$id = Yii::$app->user->identity->id;
       $token = new UserToken;
		$token->user_id = $id;
		$token->token = Yii::$app->security->generateRandomString();
		$token->created_at = time();
		
		if(YII_ENV == 'prod'){
			$url = 'https://jeb.umk.edu.my/admin/';
		}else{
			$url = '/projects/jeb/pro02/backend/web/';
		}
		
		$url = $url . 'site/login-portal?u='.$id.'&t='.$token->token;
		
		if($token->save()){
			return $this->redirect($url);
		}

    }
	

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
	
	public function actionMyError(){
		
		$this->layout = 'error';
	}
	
	
}
