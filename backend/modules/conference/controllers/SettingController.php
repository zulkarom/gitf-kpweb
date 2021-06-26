<?php

namespace backend\modules\conference\controllers;

use Yii;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use yii\db\Exception;
use yii\db\Expression;
use backend\modules\conference\models\UploadConfFile as UploadFile;
use backend\modules\conference\models\Conference;
use backend\modules\conference\models\EmailSet;
use backend\modules\conference\models\EmailTemplate;
use common\models\Model;
use backend\modules\conference\models\ConfPaper;


/**
 * ConferenceController implements the CRUD actions for Conference model.
 */
class SettingController extends Controller
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


    public function actionIndex($conf)
    {
        $model = $this->findModel($conf);

        if ($model->load(Yii::$app->request->post())) {
			if($model->save()){
				Yii::$app->session->addFlash('success', "Conference Setting Updated");
				return $this->redirect(['index', 'conf' => $conf]);
			}
			
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
    
    public function actionPaper($conf)
    {
        $model = $this->findModel($conf);
        
        if ($model->load(Yii::$app->request->post())) {
            $list = ConfPaper::find()->where(['conf_id' => $model->id])->orderBy('created_at ASC')->all();
            if($list){
                $i = 1;
                foreach($list as $paper){
                    $paper->confly_number = $i;
                    if(!$paper->save()){
                        $paper->flashError();
                    }
                   $i++;
                }
            }
            Yii::$app->session->addFlash('success', "Paper Ids Reset Successful");
            return $this->refresh();
            
        }
        
        return $this->render('paper', [
            'model' => $model,
        ]);
    }
	
	public function actionPayment($conf)
    {
        $model = $this->findModel($conf);

        if ($model->load(Yii::$app->request->post())) {
			if($model->save()){
				Yii::$app->session->addFlash('success', "Payment Information Updated");
				return $this->redirect(['payment', 'conf' => $conf]);
			}
			
        }

        return $this->render('payment', [
            'model' => $model,
        ]);
    }
	
    

    /**
     * Finds the Conference model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Conference the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Conference::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	


	public function actionUploadFile($attr, $id){
        $attr = $this->clean($attr);
        $model = $this->findModel($id);
        $model->file_controller = 'setting';

        return UploadFile::upload($model, $attr, 'updated_at');

    }

	protected function clean($string){
        $allowed = ['banner', 'logo'];
        
        foreach($allowed as $a){
            if($string == $a){
                return $a;
            }
        }
        
        throw new NotFoundHttpException('Invalid Attribute');

    }

	public function actionDeleteFile($attr, $id)
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
        $filename = strtoupper($attr) . ' ' . Yii::$app->user->identity->fullname;
        UploadFile::download($model, $attr, $filename);
    }
	
	protected function checkEmailsExist($conf){
		 $list = EmailSet::find()->all();
				if($list){
					foreach($list as $row){
						$find = EmailTemplate::find()
						->where(['conf_id' => $conf, 'templ_id' => $row->id])
						->count();
						if($find == 0){
							$tmpl = new EmailTemplate;
							$tmpl->templ_id = $row->id;
							$tmpl->conf_id = $conf;
							$tmpl->subject = $row->subject;
							$tmpl->content = $row->content;
							$tmpl->save();
						}
						
					}
				}
	}
	
	public function actionEmailTemplate($conf){
		$this->checkEmailsExist($conf);
		 $model = $this->findModel($conf);
		 $emails = $model->emails;
		 

        if ($model->load(Yii::$app->request->post())) {

			//$emails = Model::createMultiple(EmailTemplate::classname(), $emails);
			Model::loadMultiple($emails, Yii::$app->request->post());
			
			$valid = $model->validate();
            $valid = Model::validateMultiple($emails) && $valid;
			
			if ($valid) {

                $transaction = Yii::$app->db->beginTransaction();
                try {
					$model->updated_at = new Expression('NOW()');
                    if ($flag = $model->save(false)) {

                        foreach ($emails as $i => $email) {
                            if ($flag === false) {
                                break;
                            }

                            if (!($flag = $email->save(false))) {
                                break;
                            }
                        }

                    }

                    if ($flag) {
                        $transaction->commit();
                            Yii::$app->session->addFlash('success', "Emails updated");
                            return $this->redirect(['email-template','conf' => $conf]);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    
                }
			}
			
			
			
        }

        return $this->render('email-template', [
            'model' => $model,
			'emails' => $emails
        ]);
	}





}
