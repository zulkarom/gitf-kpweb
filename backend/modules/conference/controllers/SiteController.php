<?php
namespace backend\modules\conference\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use yii\db\Expression;
use backend\modules\conference\models\Conference;
use backend\modules\conference\models\ConferenceSearch;
use common\models\User;

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
                        'actions' => ['signup', 'index', 'login', 'staff-login', 'download', 'public-submit', 'subscriber', 'error', 'register'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'index', 'staff-login', 'public-submit', 'error'],
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
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
	
	public function actionError(){
		$this->layout = 'main-empty';
		
	}
	
	public function actionRegister(){
		$this->layout = 'main-login';
		$user = new User;
		$user->scenario = 'checkemail';
		
		if ($user->load(Yii::$app->request->post())) {
			if($user->isEmailExist()){
				Yii::$app->session->addFlash('error', "You have already registered with Edusage Network, please proceed to login page. You can use forgot password feature in case you have forgotten your password");
			}else{
				$this->redirect(['user/register', 'email' => $user->email]);
			}
		}

		return $this->render('register',[
			'user' => $user
		]);
	}

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
		if(Yii::$app->user->isGuest){
			$this->redirect(['user/login']);
		}else{
			
		$searchModel = new ConferenceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('member', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
			
		}
        
    }
	
	public function actionPublicSubmit(){
		if(Yii::$app->user->isGuest){
			return $this->redirect(['page/submission-guideline']);
		}else{
			return $this->redirect(['submission/create']);
		}
	}
	
	public function actionSubscriber(){
		$model = new Subscriber;
		if ($model->load(Yii::$app->request->post())) {
			$model->created_at = new Expression('NOW()');
			$model->save();
			return $this->render('subscriber', [
			]);
		}
	}
	
	/* public function actionDownload($article){
		
        $model = $this->findArticle($article);
		
		Upload::download($model, 'cameraready', 'article');
	}*/
	
	public function actionDownload($volume, $issue, $publish_number){
		
		$all = $volume.$issue;
		
		$len = strlen((string)$all);
		
		if($len == 4){
			$first = $all[0];
			$second = $all[1];
			$third = $all[2];
			$forth = $all[3];
			
			if($first == '0'){
				$volume = $second;
			}else{
				$volume = $first.$second;
			}
			
			if($third == '0'){
				$issue = $forth;
			}else{
				$issue = $third.$forth;
			}
		}else if($len == 5){
			$first = $all[0];
			$second = $all[1];
			$third = $all[2];
			$forth = $all[3];
			$fifth = $all[4];
			
			$volume = $first.$second.$third;
			
			if($forth == '0'){
				$issue = $fifth;
			}else{
				$issue = $forth.$fifth;
			}
		}
		
        $model = $this->searchArticle($volume, $issue, $publish_number);
		
		
		
		Upload::download($model, 'cameraready', 'article');
	} 
	


    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect(['/user/login']);
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
				Yii::$app->session->addFlash('success', "Registration Successful");
               return $this->redirect(['site/login']);
            }
        }
		
		$this->layout = "//main-login";

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
	
	
	
}
