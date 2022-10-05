<?php

namespace confsite\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\base\Exception;
use yii\db\Expression;
use backend\modules\conference\models\Conference;
use confsite\models\UploadPaperFile as UploadFile;
use backend\modules\conference\models\ConfRegistration;
use confsite\models\user\User;
use yii\helpers\Html;

/**
 * PaperController implements the CRUD actions for ConfPaper model.
 */
class PaymentController extends Controller
{
    /**
     * {@inheritdoc}
     */
	public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
	
	public function beforeAction($action){
		if (parent::beforeAction($action)){
			$url = Yii::$app->getRequest()->getQueryParam('confurl');
			if($url){
			    $conf = $this->findConferenceByUrl($url);
			    if(!Conference::userIsRegistered($conf->id)){
			        return $this->redirect(['site/member', 'confurl' => $url])->send();
			    }else{
			        return true;
			    }
			}else{
			    throw new NotFoundHttpException('Invalid url - no conference url provided');
			}
			
			
		}
	}

    public function actionIndex($confurl=null){
        $conf = $this->findConferenceByUrl($confurl);
        if($conf->system_only == 1){
			$this->layout = 'system-member';
		}else{
			$this->layout = 'main-member';
		}
		$model = ConfRegistration::findOne(['conf_id' => $conf->id, 'user_id' => Yii::$app->user->identity->id]);
        
        if($model->fee_status > 0){
			return $this->redirect(['view', 'confurl' => $confurl]);
		}else{
            return $this->redirect(['update', 'confurl' => $confurl]);
        }
    }
	
	
	public function actionUpdate($confurl=null)
    {
		$conf = $this->findConferenceByUrl($confurl);
        

        if($conf->system_only == 1){
			$this->layout = 'system-member';
		}else{
			$this->layout = 'main-member';
		}

		$model = ConfRegistration::findOne(['conf_id' => $conf->id, 'user_id' => Yii::$app->user->identity->id]);
        $model->scenario = 'payment';
		if($model->fee_status == 10){
			return $this->redirect(['view', 'confurl' => $confurl]);
		}
		
        if ($model->load(Yii::$app->request->post())) {
			$model->fee_paid_at = time();
			$model->fee_status = 1; // submitted
			if($model->save()){
				Yii::$app->session->addFlash('success', "Thank you, your payment has been succeessfully submited");
				return $this->redirect(['view', 'confurl' => $confurl]);
			}else{
				$model->flashError();
			}
        }

		
        if(!User::checkProfile($confurl)){
            Yii::$app->session->addFlash('info', "<i class='fa fa-info'></i> You need to complete your ". Html::a('profile ', ['profile', 'confurl' => $confurl]) ." to include your information regarding institution, phone and address.");
        }
        



		if($confurl){
			return $this->render('update', [
				'model' => $model,
				'conf' => $conf
			]);
		}
        
    }

	public function actionView($confurl=null)
    {
		$conf = $this->findConferenceByUrl($confurl);
		$model = ConfRegistration::findOne(['conf_id' => $conf->id, 'user_id' => Yii::$app->user->identity->id]);
		if($conf->system_only == 1){
			$this->layout = 'system-member';
		}else{
			$this->layout = 'main-member';
		}


		if($confurl){
			return $this->render('view', [
				'model' => $model,
				'conf' => $conf
			]);
		}
        
    }

	protected function findConferenceByUrl($url)
    {
        if (($model = Conference::findOne(['conf_url' => $url])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

	protected function findModel($id)
    {
        if (($model = ConfRegistration::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	

	public function actionUploadFile($attr, $id){
        $attr = $this->clean($attr);
        $model = $this->findModel($id);
        $model->file_controller = 'payment';
        $conf = $model->conference;
        $confurl = $conf->conf_url;

        return UploadFile::upload($model, $attr, 'updated_at');

    }

	protected function clean($string){
        $allowed = ['fee'];
        
        foreach($allowed as $a){
            if($string == $a){
                return $a;
            }
        }
        
        throw new NotFoundHttpException('Invalid Attribute');

    }

    public function actionDeleteFile($confurl, $attr, $id)
    {
        $attr = $this->clean($attr);
        $model = $this->findModel($id);
        $attr_db = $attr . '_file';
        
        $file = Yii::getAlias('@upload/' . $model->{$attr_db});
        
        $model->scenario = $attr . '_delete';
        $model->{$attr_db} = '';
        $model->updated_at = new Expression('NOW()');
        if($model->save()){
            if (is_file($file)) {
                unlink($file);
                
            }
            
            return Json::encode([
                        'good' => 1,
                    ]);
        }else{
            return Json::encode([
                        'errors' => $model->getErrors(),
                    ]);
        }
        


    }

	public function actionDownloadFile($attr, $id, $identity = true){
        $attr = $this->clean($attr);
        $model = $this->findModel($id);
        $id = $model->confly_number;
        $filename = $id . '-payment-info' ;
        UploadFile::download($model, $attr, $filename);
    }
	

}
