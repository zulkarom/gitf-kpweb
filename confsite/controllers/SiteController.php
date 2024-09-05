<?php
namespace confsite\controllers;

use frontend\models\SignupForm;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\db\Expression;
use backend\modules\conference\models\Conference;
use backend\modules\conference\models\ConfRegistration;
use confsite\models\ConferenceSearch;
use confsite\models\LoginForm;
use confsite\models\PasswordResetRequestForm;
use confsite\models\ResetPasswordForm;
use common\models\UploadFile;
use confsite\models\VerifyEmailForm;
use common\models\User;
use common\models\UserToken;
use confsite\models\NewUserFormPg;
use confsite\models\NewUserForm;
use confsite\models\SignInForm;
use InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\widgets\ActiveForm;
use yii\web\Response;



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
                        'actions' => ['login', 'index', 'error', 'register', 'home', 'download-file', 'verify-email', 'request-password-reset', 'reset-password', 'test', 'admin-login'],
                        'roles' => ['?'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['index','logout', 'member', 'error','verify-email', 'home', 'download-file', 'admin-login'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            /* 'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ], */
        ];
    }

    public function beforeAction($action) {
        if (parent::beforeAction($action)) {
           if ($action->id=='error') $this->layout ='error';
           return true;
       } 
   
    }

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
		$this->layout = 'main-list';
		$searchModel = new ConferenceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
		
    }
	
	public function actionHome($confurl=null)
    {
		$model = $this->findConferenceByUrl($confurl);
        if($model->system_only == 1){
            

            if (Yii::$app->user->isGuest) {
                return $this->redirect(['site/login', 'confurl' => $confurl]);
            }else{
                return $this->redirect(['/site/member', 'confurl' => $confurl]);
            }
        }
		if($confurl){
			return $this->render('home', [
			'model' => $model
        ]);
		}
		
    }
	
	public function actionMember($confurl=null)
    {
		if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login', 'confurl' => $confurl]);
        }
		
		$model = $this->findConferenceByUrl($confurl);
        

		if($confurl){
			
            $user = ConfRegistration::findOne(['conf_id' => $model->id, 'user_id' => Yii::$app->user->identity->id]);
            if($user){
                return $this->redirect(['/member/index', 'confurl' => $confurl]);
            }
			if ($model->load(Yii::$app->request->post())) {
				
			
				if(!$user){
					$user_id = Yii::$app->user->identity->id;
					$reg = new ConfRegistration;
					$reg->user_id = $user_id;
					$reg->conf_id = $model->id;
					$reg->confly_number = $reg->nextConflyNumber();
					$reg->reg_at = new Expression('NOW()');
					if($reg->save()){
						//email registration
						//$model->sendEmail(1, $user_id);
						Yii::$app->session->addFlash('success', "You have been successfully registered to " . $model->conf_abbr);
						return $this->redirect(['/member/index', 'confurl' => $confurl]);
					}else{
						$reg->flashError();
					}
				}else{
					return $this->redirect(['/member/index', 'confurl' => $confurl]);
				}
				
				
			}
			
			if($model->system_only == 1){
                $this->layout = 'system';
            }
			
			return $this->render('member', [
			'model' => $model
			]);
		
		
		}
		
    }

    public function actionAdminLogin($id, $confurl, $token)
    {
		if (!Yii::$app->user->isGuest) {
            Yii::$app->user->logout();
        }
		
		$last5 = time() - (60);
		
		$db = UserToken::find()
		->where(['user_id' => $id, 'token' => $token])
		->andWhere('created_at > ' . $last5)
		->one();
		
		if($db){
		   $user = User::findIdentity($id);
		   if($user){
		       if(Yii::$app->user->login($user)){
		           return $this->redirect(['member/paper', 'confurl'=> $confurl]);
		       }
		   }
			
		}
			throw new ForbiddenHttpException;

    }
	
	public function actionLogin($confurl=null)
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['site/member', 'confurl' => $confurl]);
        }


        $this->layout = '//main-login';
		$conf = $this->findConferenceByUrl($confurl);
        if($conf->system_only == 1){
            $this->layout = 'system';
        }else{
            $this->layout = "//main-login";
        }


		
		if (!Yii::$app->user->isGuest) {
            return $this->redirect(['member/index', 'confurl' => $confurl]);
        }
		
        if($conf->is_pg == 1){
            $model = new NewUserFormPg();
        }else{
            $model = new NewUserForm();
        }
		
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
            return $this->redirect(['/member/index', 'confurl' => $confurl]);
        }
        
        
        return $this->render('login', [
            'model' => $model,
            'modelLogin' => $modelLogin,
            'conf' => $conf
        ]);

    }
	
	/* public function actionError(){
		return $this->redirect(['site/index']);
	} */
	
	public function actionRegister($confurl=null, $email='')
    {
		
		$this->layout = "main-login";

        $model = \Yii::createObject(SignupForm::className());

        if ($model->load(\Yii::$app->request->post())) {
			$model->username = $model->email;
			if($model->register()){
				$this->trigger(self::EVENT_AFTER_REGISTER, $event);

				return $this->render('/message', [
					'title'  => \Yii::t('user', 'Congratulation, your account has been created'),
					'module' => $this->module,
				]);
			}else{
				//print_r($model->getErrors());
			}
        }

        return $this->render('register', [
            'model'  => $model,
			'email' => $email
        ]);

    }
	
	public function actionLogout($confurl=null){
		if($confurl){
			Yii::$app->user->logout();
            Yii::$app->session->addFlash('success', "You have been logged out.");
			return $this->redirect(['site/login', 'confurl' => $confurl]);
		}
	}
	
	
	protected function findConferenceByUrl($url)
    {
        if (($model = Conference::findOne(['conf_url' => $url])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    
	
	public function actionDownloadFile($attr, $url, $identity = true){
	    
        $attr = $this->clean($attr);
        $model = $this->findConferenceByUrl($url);
        $filename = strtoupper($attr);
        UploadFile::download($model, $attr, $filename);
    }
	
	protected function clean($string){
        $allowed = ['banner'];
        
        foreach($allowed as $a){
            if($string == $a){
                return $a;
            }
        }
        
        throw new NotFoundHttpException('Invalid Attribute');

    }

    public function actionRequestPasswordReset($confurl = null)
    {
        $conf = $this->findConferenceByUrl($confurl);
        if($conf->system_only == 1){
            $this->layout = 'system';
        }else{
            $this->layout = "//main-login";
        }
        
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail($conf)) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->redirect(['/site/login', 'confurl' => $confurl]);
                
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }
        
        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }
    
    public function actionResetPassword($token, $confurl)
    {
        $conf = $this->findConferenceByUrl($confurl);
        if($conf->system_only == 1){
            $this->layout = 'system';
        }else{
            $this->layout = "//main-login";
        }
       
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'Your new password has been successfully created.');
            
            return $this->redirect(['/site/login', 'confurl' => $confurl]);
        }
        
        return $this->render('resetPassword', [
            'model' => $model,
            'confurl' => $confurl
        ]);
    }

    protected function findConference($id)
    {
        $model = Conference::findOne($id);
        if ($model) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	

	public function actionVerifyEmail($token, $confurl)
    {
        $conf = $this->findConferenceByUrl($confurl);
        if (empty($token) || !is_string($token)) {
            //throw new InvalidArgumentException('Verify email token cannot be blank.');
            Yii::$app->session->setFlash('error', 'Verify email token cannot be blank.');
            return $this->redirect(['/site/login', 'confurl' => $confurl]);
        }
        $user = User::findByVerificationToken($token);
        if (!$user) {
            //throw new InvalidArgumentException('Wrong verify email token.');
            Yii::$app->session->setFlash('error', 'Wrong verificaton token, please check the link is correct.');
            return $this->redirect(['/site/login', 'confurl' => $confurl]);
        }

        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
           // throw new BadRequestHttpException($e->getMessage());
           Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        }

        if ($model->verifyEmail()) {
            Yii::$app->session->setFlash('success', 'Thank you, your email has been confirmed. You can now login to submit your application');
        }else{
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        }

        return $this->redirect(['/site/login', 'confurl' => $confurl]);
        
    }
}
