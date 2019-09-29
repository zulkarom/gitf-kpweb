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
use backend\modules\erpd\models\Stats as Dashboard;

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
                        'actions' => ['login', 'login-portal', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'test'],
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
		$dashboard = new Dashboard;
        return $this->render('index', [

		'customer' => 33
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
	
	public function actionLoginPortal($u,$t)
    {
        /* if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        } */
	

        $last5 = time() - (60);
		
		$db = Staff::find()
		->where(['staff_id' => $u, 'user_token' => $t])
		->andWhere('user_token_at > ' . $last5)
		->one();
		
		$staff = Staff::findOne(['staff_id' => $u]);
		$id = $staff->user_id;
		//echo $id;
		
		if($db){
		   $user = User::findIdentity($id);
			if(Yii::$app->user->login($user)){
				return $this->redirect(['/website']);
			}
		}else{
			throw new ForbiddenHttpException;
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
}
