<?php
namespace frontend\modules\conference\controllers;

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
use backend\modules\conference\models\ConfRegistration;
use frontend\modules\conference\models\ConferenceSearch;
use frontend\modules\conference\models\LoginForm;
use frontend\modules\conference\models\SignupForm;
use common\models\UploadFile;



/**
 * Site controller
 */
class SiteController extends Controller
{
	public $layout = 'main';
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            /* 'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', ],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ], */
          
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
		$this->layout = 'main-login';
		$model = $this->findConferenceByUrl($confurl);
		
		if($confurl){
			
			if ($model->load(Yii::$app->request->post())) {
				$user = ConfRegistration::findOne(['conf_id' => $model->id, 'user_id' => Yii::$app->user->identity->id]);
			
				if(!$user){
					$user_id = Yii::$app->user->identity->id;
					$reg = new ConfRegistration;
					$reg->user_id = $user_id;
					$reg->conf_id = $model->id;
					$reg->confly_number = $reg->nextConflyNumber();
					$reg->reg_at = new Expression('NOW()');
					if($reg->save()){
						//email registration
						$model->sendEmail(1, $user_id);
						Yii::$app->session->addFlash('success', "You have been successfully registered to " . $model->conf_abbr);
						return $this->redirect(['member/index', 'confurl' => $confurl]);
					}else{
						$reg->flashError();
					}
				}
				
				
			}
			
			
			
			return $this->render('member', [
			'model' => $model
			]);
		
		
		}
		
    }
	
	public function actionLogin($confurl=null)
    {
		
		if (!Yii::$app->user->isGuest) {
            return $this->redirect(['member/index', 'confurl' => $confurl]);
        }
		$this->layout = 'main-login';
		$conf = $this->findConferenceByUrl($confurl);
		
		if($confurl){
			$model = new LoginForm();
			if ($model->load(Yii::$app->request->post()) && $model->login()) {
				return $this->redirect(['member/index', 'confurl' => $confurl]);
				
			} else {
				return $this->render('login', [
					'model' => $model,
					'conf' => $conf
				]);
			}
		}

    }
	
	public function actionError(){
		return $this->redirect(['site/index']);
	}
	
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
	

	
}
