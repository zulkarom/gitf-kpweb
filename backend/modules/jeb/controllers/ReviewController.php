<?php

namespace backend\modules\jeb\controllers;

use Yii;
use backend\modules\jeb\models\Article;
use backend\modules\jeb\models\ReviewSearch;
use backend\modules\jeb\models\ArticleReviewer;
use backend\modules\jeb\models\UserScope;
use common\models\Upload;
use yii\db\Expression;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use raoul2000\workflow\validation\WorkflowScenario;
use common\models\Model;
use common\models\UserToken;
use yii\filters\AccessControl;
use backend\modules\jeb\models\Setting;
use common\models\User;
use yii\web\NotFoundHttpException;

class ReviewController extends \yii\web\Controller
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

        $searchModel = new ReviewSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	
	public function actionManuscriptInfo($id){
		$this->layout= 'ajax';
		$model = $this->findModel($id);
		return $this->render('manuscript_info', [
				'model' => $model,
		]);
		
	}
	
	public function actionManuscriptNo($id){
		$model = $this->findModel($id);
		$model->scenario = 'manuscript';
		
		
	if ($model->load(Yii::$app->request->post())) {
		
		//Yii::$app->session->addFlash('error', $model->id . '=' . $model->manuscript_no);
		
		if($id == $model->manuscript_no){
			Yii::$app->session->addFlash('error', "Manuscript no. cannot be equal to article id: " . $model->id);
		}
		
		if($model->save()){
			return $this->redirect(['pre-evaluate', 'id' => $model->id]);
		}else{
			
			$model->flashError();
		}
	}

		
		return $this->render('manuscript_no', [
            'model' => $model
        ]);
		
	}
	
	public function actionPreEvaluate($id)
    {
	
	
	$model = $this->findModel($id);
	
	//check manuscript no first
	
	if($id == $model->manuscript_no){
		return $this->redirect(['manuscript-no', 'id' => $model->id]);
	}
	
	
	
	$reject_model = $this->findModel($id);
	
	$status = $model->wfStatus;
	$model->scenario = WorkflowScenario::enterStatus('ca-assign-reviewer');
	$reject_model->scenario = WorkflowScenario::enterStatus('ra-reject');
		
		if ($model->load(Yii::$app->request->post())) {
			$wfaction = Yii::$app->request->post('wfaction');
			if($wfaction == 'assign-associate'){
				return $this->assignAssociate($model);
			}else if($wfaction == 'reject'){
				return $this->reject($reject_model);
			}
		}
		return $this->render('pre_evaluate', [
            'model' => $model,
			'reject_model' => $reject_model
        ]);
	}
	
	public function actionAssignReviewer($id)
    {
	$model = $this->findModel($id);
	$status = $model->wfStatus;
	if($model->associate_editor == Yii::$app->user->identity->id and $status == 'assign-reviewer'){
		$model->scenario = WorkflowScenario::enterStatus('ca-assign-reviewer');
			$reviewers = $model->articleReviewers;
			if ($model->load(Yii::$app->request->post())) {
				$wfaction = Yii::$app->request->post('wfaction');
				if($wfaction == 'assign-reviewer'){
					
					return $this->assignReviewer($model, $reviewers);
				}
			}
			return $this->render('assign_reviewer', [
				'model' => $model,
				'reviewers' => (empty($reviewers)) ? [new ArticleReviewer(['scenario' => 'assign'])] : $reviewers
			]);
	}
	
		
        
    }

    /* public function actionView($id)
    {
	
	$model = $this->findModel($id);
	$status = $model->wfStatus;
	$model->scenario = WorkflowScenario::enterStatus('ja-galley-proof');
	if($status == 'pre-evaluate' or $status == 'post-evaluate'){
		
		if ($model->load(Yii::$app->request->post())) {
			$wfaction = Yii::$app->request->post('wfaction');
			if($wfaction == 'assign-associate'){
				return $this->assignAssociate($model);
			}else if($wfaction == 'send-galley'){
				return $this->assignAssistant($model);
			}
		}
		return $this->render('view', [
            'model' => $model,
        ]);
	}else if($status == 'assign-reviewer'){
		$reviewers = $model->articleReviewers;
		if ($model->load(Yii::$app->request->post())) {
			$wfaction = Yii::$app->request->post('wfaction');
			if($wfaction == 'assign-reviewer'){
				
				return $this->assignReviewer($model, $reviewers);
			}
		}
		return $this->render('view', [
            'model' => $model,
			'reviewers' => (empty($reviewers)) ? [new ArticleReviewer] : $reviewers
        ]);
	}
		
        
    } */
	
	protected function assignReviewer($model, $reviewers){
		$model->scenario = WorkflowScenario::enterStatus('da-review');
        
        if ($model->load(Yii::$app->request->post())) {
			
			/* assign reviewer */
			$model->asgn_reviewer_at = new Expression('NOW()');	
			
			$model->sendToStatus('da-review');
			/////////////////////////
			
            
            $reviewers = Model::createMultiple(ArticleReviewer::classname());
			
            Model::loadMultiple($reviewers, Yii::$app->request->post());
			
            
            $valid = $model->validate();
            
            $valid = Model::validateMultiple($reviewers) && $valid;
            
            if ($valid) {

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        
                        foreach ($reviewers as $indexAu => $reviewer) {
                            
                            if ($flag === false) {
                                break;
                            }
							
							$reviewer->scenario = 'assign';
							
							//do not validate this in model
                            $reviewer->article_id = $model->id;
							$reviewer->created_at =  new Expression('NOW()');

                            if (!($flag = $reviewer->save(false))) {
                                break;
                            }
							
							//determine admin creation zero last login
							if($reviewer->isAssociateAdminCreationNeverLogin()){
								$model->sendReviewerEmail($reviewer->user, 'Assign-notify-reviewer-external-first');
							}else{
								$model->sendReviewerEmail($reviewer->user, 'Assign-notify-reviewer');
							}
							
                        }

                    }

                    if ($flag) {
                        $transaction->commit();
						//TODO: this flash x work
						
						$model->sendEmail();
						
						
						Yii::$app->session->addFlash('success', "Reviewer(s) Assignment Successful");
						
						return $this->redirect('index');
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    
                }
            }
        }

	}
	
	protected function reject($model){
		$model->scenario = WorkflowScenario::enterStatus('ra-reject');
		$model->reject_at = new Expression('NOW()');
		$model->reject_by = Yii::$app->user->identity->id;
		$model->sendToStatus('ra-reject');
		if($model->save()){
			$model->sendEmail();
			Yii::$app->session->addFlash('success', "The manuscript has been successfully sent to rejected page.");
			return $this->redirect(['/jeb/reject/index']);
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
			return $this->redirect(['pre-evaluate', 'id' => $model->id]);

		}
	}
	
	protected function assignAssociate($model){
		/* ASSIGN ASSOCIATE */
		$model->pre_evaluate_at = new Expression('NOW()');
		$model->pre_evaluate_by = Yii::$app->user->identity->id;
		$model->sendToStatus('ca-assign-reviewer');
		/////////////
		
		if($model->save()){
			$model->sendEmail();
			Yii::$app->session->addFlash('success', "Associate Editor has been successfully assigned.");
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
			return $this->redirect(['pre-evaluate', 'id' => $model->id]);

		}
	}
	
	public function actionUpdateReviewer($id)
    {
	$model = $this->findModel($id);
	$status = $model->wfStatus;
	if($model->associate_editor == Yii::$app->user->identity->id and $status == 'review'){

			if ($model->load(Yii::$app->request->post())) {
				$wfaction = Yii::$app->request->post('wfaction');
				if($wfaction == 'assign-reviewer'){
					
					return $this->updateReviewer($model);
					
				}else if($wfaction == 'send-recommend'){
					//check all review complete first
					if(!$model->checkInProgressReviewers()){
						$model->scenario = WorkflowScenario::enterStatus('ea-recommend');
						$model->review_at = new Expression('NOW()');
						$model->sendToStatus('ea-recommend');
						if($model->save()){
							$model->sendEmail();
							Yii::$app->session->addFlash('success', "Report sent.");
							return $this->redirect('index');
						}else{
							$model->flashError();
						}
					}else{
						Yii::$app->session->addFlash('error', "Review in Progress or Appoint status still exist, do cancel first before submit.");
					}
				}
			}
			return $this->render('update_reviewer', [
				'model' => $model,
				'reviewers' => (empty($reviewers)) ? [new ArticleReviewer(['scenario' => 'assign'])] : $reviewers 
				
				
			]);
	}
	   
    }
	
	public function actionCancelReview($id){
		$review = $this->findReviewer($id);
		$review->scenario = 'cancel';
		$review->status = 40; //cancel
		$review->cancel_at = new Expression('NOW()');
		if($review->save()){
			Yii::$app->session->addFlash('success', "Cancel done.");
			return $this->redirect(['update-reviewer', 'id' => $review->article_id]);
		}
	}
	
	protected function updateReviewer($model){
        
        if ($model->load(Yii::$app->request->post())) {
				
            
            $reviewers = Model::createMultiple(ArticleReviewer::classname());
			
            Model::loadMultiple($reviewers, Yii::$app->request->post());
            
            $valid = $model->validate();
            
            $valid = Model::validateMultiple($reviewers) && $valid;
            
            if ($valid) {

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        
                        foreach ($reviewers as $indexAu => $reviewer) {
                            
                            if ($flag === false) {
                                break;
                            }
							
							$reviewer->scenario = 'assign';
							//do not validate this in model
                            $reviewer->article_id = $model->id;
							$reviewer->created_at = new Expression('NOW()');

                            if (!($flag = $reviewer->save(false))) {
                                break;
                            }
							
							if($reviewer->isAssociateAdminCreationNeverLogin()){
								$model->sendReviewerEmail($reviewer->user, 'Assign-notify-reviewer-external-first');
							}else{
								$model->sendReviewerEmail($reviewer->user, 'Assign-notify-reviewer');
							}
							
                        }

                    }

                    if ($flag) {
                        $transaction->commit();
						Yii::$app->session->addFlash('success', "Reviewer(s) Assignment updated.");
						return $this->redirect(['review/index']);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    
                }
            }
        }

	}
	
	public function actionPostEvaluate($id)
    {
	
	$model = $this->findModel($id);
	$status = $model->wfStatus;
	$model->scenario = WorkflowScenario::enterStatus('ja-galley-proof');
	
	$model_review = $this->findModel($id);
	$model_review->scenario = WorkflowScenario::enterStatus('ca-assign-reviewer');
	
	if($status == 'post-evaluate'){
		
		if ($model->load(Yii::$app->request->post())) {
			$wfaction = Yii::$app->request->post('wfaction');
			if($wfaction == 'assign-associate'){
				return $this->assignAssociate($model);
			}else if($wfaction == 'send-galley'){
				//notify author
				$model->sendEmail("Author-accept");
				return $this->assignAssistant($model);
			}
		}
		return $this->render('post_evaluate', [
            'model' => $model,
			'model_review' => $model_review
        ]);
	}
		
        
    }
	
	protected function assignAssistant($model){
		$model->scenario = WorkflowScenario::enterStatus('ja-galley-proof');
		$model->post_evaluate_at = new Expression('NOW()');
		$model->post_evaluate_by = Yii::$app->user->identity->id;
		$model->sendToStatus('ja-galley-proof');
		if($model->save()){
			$model->sendEmail();
			Yii::$app->session->addFlash('success', "Assistant Editor has been successfully assigned.");
			return $this->redirect(['editing/index']);
		}
	}
	
	/* protected function assignAssociate($model){
		$model->pre_evaluate_at = new Expression('NOW()');
		$model->pre_evaluate_by = Yii::$app->user->identity->id;
		$model->sendToStatus('ca-assign-reviewer');
		if($model->save()){
			Yii::$app->session->addFlash('success', "Associate Editor has been successfully assigned.");
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
			return $this->redirect(['pre-evaluate', 'id' => $model->id]);

		}
	} */

    public function actionView($id)
    {
	
	$model = $this->findModel($id);
	$status = $model->wfStatus;
		
	if($status == 'pre-evaluate'){
		if ($model->load(Yii::$app->request->post())) {
			$wfaction = Yii::$app->request->post('wfaction');
			if($wfaction == 'assign-associate'){
				$this->assignAssociate($model);
			}
		}
		return $this->render('view', [
            'model' => $model,
        ]);
	}else if($status == 'assign-reviewer'){
		$reviewers = $model->articleReviewers;
		if ($model->load(Yii::$app->request->post())) {
			$wfaction = Yii::$app->request->post('wfaction');
			if($wfaction == 'assign-reviewer'){
				
				return $this->assignReviewer($model, $reviewers);
			}
		}
		return $this->render('view', [
            'model' => $model,
			'reviewers' => (empty($reviewers)) ? [new ArticleReviewer] : $reviewers
        ]);
	}else if($status == 'review'){
		$reviewers = $model->articleReviewers;
		return $this->render('view', [
            'model' => $model,
			'reviewers' => $reviewers
        ]);
        
    }
	
	if($model->isReviewer()){
		return $this->render('view', [
            'model' => $model,
        ]);
	}
	
	}
	
	public function actionRecommend($id)
    {
	
	$model = $this->findModel($id);
	$model->scenario = WorkflowScenario::enterStatus('fa-evaluate');
	$status = $model->wfStatus;
	if($status == 'recommend'){
		$reviewers = $model->completedReviewers;
		
		if ($model->load(Yii::$app->request->post())) {
			/* STATUS Recommendation */
			$model->recommend_at = new Expression('NOW()');
			$model->recommend_by = Yii::$app->user->identity->id;
			$model->sendToStatus('fa-evaluate');
			if($model->save()){
				$model->sendEmail();
				Yii::$app->session->addFlash('success', "Recommendation has been successfully sent.");
				return $this->redirect('index');
			}


			
		}
		return $this->render('recommend', [
			'model' => $model,
			'reviewers' => $reviewers
		]);
	}
	
		
        
    }
	
	public function actionResponse($id)
    {
	
	$model = $this->findModel($id);
	$status = $model->wfStatus;
	if($status == 'response'){
		$reviewers = $model->completedReviewers;
		
	if ($model->load(Yii::$app->request->post())) {
		//print_r(Yii::$app->request->post());
		$wfaction = Yii::$app->request->post('wfaction');
		//echo $wfaction;
		//echo Yii::$app->request->post('response_note');
		//echo $model->response_note;
		$model->response_at = new Expression('NOW()');
		$model->response_by = Yii::$app->user->identity->id;
		
		
			if($wfaction == 'reject'){
				return $this->reject($reject_model);
				
			}else{
				$model->scenario = WorkflowScenario::enterStatus('ha-correction');
				$model->sendToStatus('ha-correction');
				if($model->save()){
					$model->sendEmail();
					Yii::$app->session->addFlash('success', "The response has been successfully sent.");
					return $this->redirect('index');
				}
			}
			
			

		
	}
	return $this->render('response', [
		'model' => $model,
		'reviewers' => $reviewers
	]);
	}
	
	
		
        
    }
	
	public function actionEvaluate($id)
    {
	
	$model = $this->findModel($id);
	$model->scenario = WorkflowScenario::enterStatus('ga-response');
	$status = $model->wfStatus;
	$reviewers = $model->completedReviewers;
		
	if ($model->load(Yii::$app->request->post())) {
		$model->evaluate_at = new Expression('NOW()');
		$model->evaluate_by = Yii::$app->user->identity->id;
        $model->sendToStatus('ga-response');
		if($model->save()){
			$model->sendEmail();
            Yii::$app->session->addFlash('success', "Evaluation has been successfully sent.");
            return $this->redirect('index');
        }


		
	}
	return $this->render('evaluate', [
		'model' => $model,
		'reviewers' => $reviewers
	]);
		
        
    }
	
	public function actionLoginReviewer($id)
    {
		$token = new UserToken;
		$token->setToken();
		$user = Yii::$app->user->identity->id;
		if($token->save()){
			return $this->redirect(Yii::$app->urlManager->createUrl(Setting::$frontUrl .'site/staff-login?id='.$user.'&redirect=review&action=review-form&article='.$id.'&token='.$token->token));
		}
    }
	
	public function actionUpload($attr, $id){
        $attr = $this->clean($attr);
        $model = $this->findModel($id);
        $model->file_controller = 'submission';

        return Upload::upload($model, $attr, 'updated_at');

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
	
	 protected function findReviewer($id)
    {
        if (($model = ArticleReviewer::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	public function actionDownload($attr, $id, $identity = true){
		$attr = $this->clean($attr);
        $model = $this->findReviewer($id);
		$filename = strtoupper($attr);
		Upload::download($model, $attr, $filename);
	}
	
	public function actionDownloadReviewFile($attr, $id, $identity = true){
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
	
	public function actionListReviewers($scope){
		$reviewers = UserScope::listReviewers($scope);
		
		return Json::encode($reviewers);
		
	}

}
