<?php

namespace backend\modules\jeb\controllers;

use Yii;
use backend\modules\jeb\models\Article;
use backend\modules\jeb\models\EditingSearch;
use common\models\Upload;
use yii\db\Expression;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use raoul2000\workflow\validation\WorkflowScenario;
use common\models\Model;
use common\models\UserToken;
use backend\modules\jeb\models\Setting;
use yii\filters\AccessControl;

class EditingController extends \yii\web\Controller
{

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

	
    public function actionIndex()
    {

        $searchModel = new EditingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionGalley($id)
    {
	
		$model = $this->findModel($id);
		$model->scenario = WorkflowScenario::enterStatus('ka-assign-proof-reader');
			
		if ($model->load(Yii::$app->request->post())) {
			$model->asgn_profrdr_at = new Expression('NOW()');
			$model->asgn_profrdr_by = Yii::$app->user->identity->id;
			$model->sendToStatus('ka-assign-proof-reader');
			if($model->save()){
				$model->sendEmail();
				Yii::$app->session->addFlash('success', "Galley Proof has been done successfully.");
				return $this->redirect('index');
			}else{
				if($model->getErrors()){
					foreach($model->getErrors() as $error){
						if($error){
							foreach($error as $e){
								Yii::$app->session->addFlash('error', $e);
							}
						}
					}
				}
				return $this->redirect(['galley', 'id'=> $id]);

			}
		}
		return $this->render('galley', [
			'model' => $model,
		]);
		
        
    }
	
	public function actionAssignProofReader($id)
    {
		$model = $this->findModel($id);
		$model->scenario = WorkflowScenario::enterStatus('la-proofread');
			
		if ($model->load(Yii::$app->request->post())) {
			
			$model->proofread_at = new Expression('NOW()');
			$model->proofread_by = Yii::$app->user->identity->id;
			
			$model->sendToStatus('la-proofread');
			if($model->save()){
				$model->sendEmail();
				Yii::$app->session->addFlash('success', "Proofreader has been successfully assigned.");
				return $this->redirect('index');
			}else{
				if($model->getErrors()){
				foreach($model->getErrors() as $error){
					if($error){
						foreach($error as $e){
							Yii::$app->session->addFlash('error', $e);
						}
					}
				}
				return $this->redirect(['editing/assign_proof_reader', 'id' => $model->id]);
			}

			}
		}
		return $this->render('assign_proof_reader', [
			'model' => $model,
		]);
    }
	
	/* public function actionPostFinalise($id)
    {
		$model = $this->findModel($id);
		$model->scenario = WorkflowScenario::enterStatus('ma-proofread');
			
		if ($model->load(Yii::$app->request->post())) {
			
			$model->post_finalise_at = new Expression('NOW()');
			$model->post_finalise_by = Yii::$app->user->identity->id;
			$model->asgn_profrdr_at = new Expression('NOW()');
			$model->asgn_profrdr_by = Yii::$app->user->identity->id;
			
			$model->sendToStatus('ma-proofread');
			if($model->save()){
				Yii::$app->session->addFlash('success', "Proofreader has been successfully assigned.");
				return $this->redirect('index');
			}else{
				if($model->getErrors()){
				foreach($model->getErrors() as $error){
					if($error){
						foreach($error as $e){
							Yii::$app->session->addFlash('error', $e);
						}
					}
				}
				return $this->redirect(['editing/post-finalise', 'id' => $model->id]);
			}

			}
		}
		return $this->render('post_finalise', [
			'model' => $model,
		]);
    } */
	
	public function actionCameraReady($id)
    {
		$model = $this->findModel($id);
		$model->scenario = WorkflowScenario::enterStatus('pa-assign-journal');
			
		if ($model->load(Yii::$app->request->post())) {
			
			$model->camera_ready_at = new Expression('NOW()');
			$model->camera_ready_by = Yii::$app->user->identity->id;
			
			$model->sendToStatus('pa-assign-journal');
			if($model->save()){
				$model->sendEmail();
				Yii::$app->session->addFlash('success', "The article has been successfully send to journal.");
				return $this->redirect(['publish/index']);
			}else{
				if($model->getErrors()){
				foreach($model->getErrors() as $error){
					if($error){
						foreach($error as $e){
							Yii::$app->session->addFlash('error', $e);
						}
					}
				}
				return $this->redirect(['editing/camera-ready', 'id' => $model->id]);
			}

			}
		}
		return $this->render('camera_ready', [
			'model' => $model,
		]);
    }
	
	/* public function actionAssignProofReader($id)
    {
		$model = $this->findModel($id);
		$model->scenario = WorkflowScenario::enterStatus('ma-proofread');
			
		if ($model->load(Yii::$app->request->post())) {
			
			$model->asgn_profrdr_at = new Expression('NOW()');
			$model->asgn_profrdr_by = Yii::$app->user->identity->id;
			
			$model->sendToStatus('ma-proofread');
			if($model->save()){
				Yii::$app->session->addFlash('success', "Proofreader has been successfully assigned.");
				return $this->redirect('index');
			}
		}
		return $this->render('assign-proof-reader', [
			'model' => $model,
		]);
    } */
	
	
	
	public function actionLoginProofRead($id)
    {
		$token = new UserToken;
		$token->setToken();
		$user = Yii::$app->user->identity->id;
		if($token->save()){
			return $this->redirect(Yii::$app->urlManager->createUrl(Setting::$frontUrl .'site/staff-login?id='.$user.'&redirect=editing&action=proofread&article='.$id.'&token='.$token->token));
		}
    }
	
	public function actionUpload($attr, $id){
        $attr = $this->clean($attr);
        $model = $this->findModel($id);
        $model->file_controller = 'editing';

        return Upload::upload($model, $attr, 'updated_at');

    }
	
	public function actionDownload($attr, $id, $identity = true){
		$attr = $this->clean($attr);
        $model = $this->findModel($id);
		$filename = strtoupper($attr);
		Upload::download($model, $attr, $filename);
	}
	
	public function actionDelete($attr, $id)
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
	
	protected function clean($string){
		return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
	}
	
	/**
     * Finds the Article model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Article the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	

}
