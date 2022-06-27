<?php

namespace confsite\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\base\Exception;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use common\models\Model;
use common\models\User;
use backend\modules\conference\models\ConfPaper;
use backend\modules\conference\models\ConfAuthor;
use backend\modules\conference\models\Conference;
use backend\modules\conference\models\pdf\InvoicePdf;
use backend\modules\conference\models\pdf\ReceiptPdf;
use backend\modules\conference\models\PaperReviewer;
use backend\modules\conference\models\pdf\AcceptLetterPdf;
use confsite\models\UploadPaperFile as UploadFile;
use confsite\models\ConfPaperSearch;
use confsite\models\ReviewSearch;
use backend\modules\conference\models\Associate;
use backend\modules\conference\models\ConfRegistration;

/**
 * PaperController implements the CRUD actions for ConfPaper model.
 */
class MemberController extends Controller
{
	public $layout = 'main-member';
	
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
	
	
	public function actionIndex($confurl=null)
    {
		return $this->redirect(['member/paper', 'confurl' => $confurl]);
	}

    /**
     * Lists all ConfPaper models.
     * @return mixed
     */
    public function actionPaper($confurl=null)
    {
		
		$conf = $this->findConferenceByUrl($confurl);
		if($conf->system_only == 1){
			$this->layout = 'system-member';
		}else{
			$this->layout = 'main-member';
		}
        $searchModel = new ConfPaperSearch();
		$searchModel->conf_id = $conf->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		if($confurl){
			return $this->render('paper', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
				'conf' => $conf
			]);
		}
        
    }
	
	public function actionReview($confurl=null)
    {
		$conf = $this->findConferenceByUrl($confurl);
		if($conf->system_only == 1){
			$this->layout = 'system-member';
		}else{
			$this->layout = 'main-member';
		}

        $searchModel = new ReviewSearch();
		$searchModel->conf_id = $conf->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		if($confurl){
			return $this->render('review', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
				'conf' => $conf
			]);
		}
        
    }
	
	 protected function findReviewer($id)
    {
        if (($model = PaperReviewer::findOne(['paper_id' => $id, 'user_id' => Yii::$app->user->identity->id])) !== null) {
            return $model;
        }else{
			$review = new PaperReviewer;
			$review->scenario = 'create';
			$review->paper_id = $id;
			$review->user_id = Yii::$app->user->identity->id;
			$review->save();
			return $review;
		}

    }
	
	public function actionReviewForm($confurl=null,$id){
		$conf = $this->findConferenceByUrl($confurl);
		if($conf->system_only == 1){
			$this->layout = 'system-member';
		}else{
			$this->layout = 'main-member';
		}


		if($confurl){
        $model = $this->findModel($id);
		$review = $this->findReviewer($id);
		$review->scenario = 'review';
		/* if($review->status == 20){
			return $this->redirect(['review/review-completed', 'id' => $id]);
		} */
		
		if($review->load(Yii::$app->request->post())){
			$reg = ConfRegistration::findOne(['conf_id' => $conf->id, 'user_id' => Yii::$app->user->identity->id]);
			if($reg){
				$reg->is_reviewer = 1;
				$reg->save();
			}
			$wfaction = Yii::$app->request->post('wfaction');
			if($wfaction=='save'){
				if($review->save()){
					Yii::$app->session->addFlash('success', "Your work has been successfully saved. Please submit your review once it's ready, thank you.");
				}
			}else if($wfaction=='submit'){
				$review->scenario = 'review';
				$review->completed_at = new Expression('NOW()');
				
				
				
				$review->status = 20;
				if($review->save()){
				    
				    
					//maybe email appreciation
					//$model->sendReviewerEmail(Yii::$app->user->identity, 'Appreciate-reviewer');
					
					//if no other in progress
					/* if(!$model->checkInProgressReviewers()){
						$model->sendEmail('After-all-reviewers-finished');
					} */
				    
				    if($review->review_option == 5){
				        $model->status = 70; // paper correction
				    }else if($review->review_option == 10){
				        $model->status = 100; // paper accepted
				    }else if($review->review_option == 1){
				        $model->status = 10; // reject
				        $model->reject_note = $review->reject_note;
				    }
				    
				    $model->save();
				    
				    
					Yii::$app->session->addFlash('success', "Thank you, your review has been successfully submitted.");
					return $this->redirect(['review', 'confurl' => $confurl]);
				}else{
					$review->flashError();
				}
			}
			
		}
		
		return $this->render('review_form', [
            'model' => $model,
			'review' => $review
        ]);
		}
		
	}
	
	
	
	public function actionInvoiceView($confurl=null, $id)
    {
		$conf = $this->findConferenceByUrl($confurl);
		if($conf->system_only == 1){
			$this->layout = 'system-member';
		}else{
			$this->layout = 'main-member';
		}
        $model = $this->findModel($id);
		$model->scenario = 'payment';
		if($confurl){
			
			if ($model->load(Yii::$app->request->post())) {
			$model->payment_at = new Expression('NOW()');
			$model->status = 90;
			
			if($model->save()){
				Yii::$app->session->addFlash('success', "Thank you for your payment, please wait while the organizer reviews your payment.");
				return $this->redirect(['member/paper', 'confurl' => $confurl]);
			}
			
			}
			
			
			return $this->render('invoice-view', [
				'model' => $model
			]);
		}
        
    }
	
	public function actionCompleteView($confurl=null, $id)
    {
		$conf = $this->findConferenceByUrl($confurl);
		if($conf->system_only == 1){
			$this->layout = 'system-member';
		}else{
			$this->layout = 'main-member';
		}

        $model = $this->findModel($id);
		if($confurl){
			
			return $this->render('complete-view', [
				'model' => $model
			]);
		}
        
    }
	
    public function actionRejectView($confurl=null, $id)
    {
		$conf = $this->findConferenceByUrl($confurl);
		if($conf->system_only == 1){
			$this->layout = 'system-member';
		}else{
			$this->layout = 'main-member';
		}

        $model = $this->findModel($id);
        if($confurl){
            
            return $this->render('reject-view', [
                'model' => $model
            ]);
        }
        
    }
    
	public function actionProfile($confurl=null)
    {
		$conf = $this->findConferenceByUrl($confurl);
		if($conf->system_only == 1){
			$this->layout = 'system-member';
		}else{
			$this->layout = 'main-member';
		}
		
		if($confurl){
			$user = User::findOne(Yii::$app->user->identity->id);
			$associate = $user->associate;
			
			if(!$associate){
			    $new = new Associate();
			    $new->scenario = 'raw';
			    $new->user_id = $user->id;
			    if(!$new->save()){
					print_r($new->getErrors());
					die();
				}

				return $this->refresh();
			}
			
			if($conf->is_pg == 1){
				$associate->scenario = 'conf_profile_pg';
			}
			
			$user->scenario = 'conf_profile';
		
			if ($user->load(Yii::$app->request->post()) && $associate->load(Yii::$app->request->post())) {
			  //  print_r(Yii::$app->request->post());die();
				if($user->save() && $associate->save()){
					Yii::$app->session->addFlash('success', "Profile Updated");
					return $this->redirect(['member/profile', 'confurl' => $confurl]);
				}else{
				    $user->flashError();
				    $associate->flashError();
				}
			
			}

			if($conf->is_pg == 1){
				return $this->render('profile_pg', [
					'user' => $user,
					'associate' => $associate
				]);
			}else{
				return $this->render('profile', [
					'user' => $user,
					'associate' => $associate
				]);
			}
			

		}
        
    }

    /**
     * Displays a single ConfPaper model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ConfPaper model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
	public function actionCreate($confurl=null)
    {
		$conf = $this->findConferenceByUrl($confurl);
		if($conf->system_only == 1){
			$this->layout = 'system-member';
		}else{
			$this->layout = 'main-member';
		}


		if($confurl){
		$model = new ConfPaper();
		$conf = $this->findConferenceByUrl($confurl);
		$model->scenario = 'create';

        $authors = [new ConfAuthor];
       
        if ($model->load(Yii::$app->request->post())) {
			$model->conf_id = $conf->id;
			$model->user_id = Yii::$app->user->identity->id;
			$model->created_at = new Expression('NOW()');
			$model->updated_at = new Expression('NOW()');
			$model->abstract_at = new Expression('NOW()');
			$model->status = 30;
			$model->confly_number = $model->nextConflyNumber();
			$abstract_full = $model->form_abstract_only;

				
            $authors = Model::createMultiple(ConfAuthor::classname());
            Model::loadMultiple($authors, Yii::$app->request->post());
            
            foreach ($authors as $i => $author) {
                $author->author_order = $i;
            }
            
            
            $valid = $model->validate();
            if(!$valid){
                $model->flashError();
            }
            
            $valid = Model::validateMultiple($authors) && $valid;
            
            if ($valid) {
                
                $transaction = Yii::$app->db->beginTransaction();
               /// die();
                try {
                    if ($flag = $model->save(false)) {
                        //die();
                        foreach ($authors as $i => $author) {
                            if ($flag === false) {
                                break;
                            }
                            //do not validate this in model
                            $author->paper_id = $model->id;

                            if (!($flag = $author->save(false))) {
                                break;
                            }
                        }
						// update reg as author 
						$reg = ConfRegistration::findOne(['conf_id' => $conf->id, 'user_id' => Yii::$app->user->identity->id]);
						if($reg){
							$reg->is_author = 1;
							$reg->save();
						}
                    }else{
                        //print_r($model->getErrors());die();
                        $model->flashError();
                    }

                    if ($flag) {
                        $transaction->commit();
							if($abstract_full == 1){
								Yii::$app->session->addFlash('success', "Thank you, your abstract has been successfully submitted");
								return $this->redirect(['member/index', 'confurl'=> $confurl]);
							}else if($abstract_full == 2){
								return $this->redirect(['member/upload', 'confurl'=> $confurl, 'id' => $model->id]);
							}
                            
                            
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    
                }
            }

        
        
       

    }
    
     return $this->render('abstract', [
            'model' => $model,
            'authors' => (empty($authors)) ? [new ConfAuthor] : $authors,
         'conf' => $conf
        ]);
   
	} 
	
	}
	
	public function actionUpload($confurl=null,$id){
		$conf = $this->findConferenceByUrl($confurl);
		if($conf->system_only == 1){
			$this->layout = 'system-member';
		}else{
			$this->layout = 'main-member';
		}

		if($confurl){
        $model = $this->findModel($id);
		$model->scenario = 'fullpaper';
        if ($model->load(Yii::$app->request->post())) {
            $model->updated_at = new Expression('NOW()'); 
			$model->full_paper_at = new Expression('NOW()');
			$model->status = 35;
			if($model->save()){
				Yii::$app->session->addFlash('success', "Thank you, your full paper has been successfully submitted.");
				return $this->redirect(['member/index', 'confurl' => $confurl]);
			}else{
				$model->flashError();
				return $this->redirect(['member/upload', 'confurl' => $confurl, 'id' => $id]);
				
			}
           
        }
    }
    
     return $this->render('upload', [
            'model' => $model
        ]);
   
	}
	
	public function actionFullPaper($confurl=null,$id){
		$conf = $this->findConferenceByUrl($confurl);
		if($conf->system_only == 1){
			$this->layout = 'system-member';
		}else{
			$this->layout = 'main-member';
		}


		if($confurl){
        $model = $this->findModel($id);
		$model->scenario = 'fullpaper';
		
		
		$authors = $model->authors;
		
		if ($model->load(Yii::$app->request->post())) {
		    
		    $model->updated_at = new Expression('NOW()');
		    
		    $authors = Model::createMultiple(ConfAuthor::classname());
		    Model::loadMultiple($authors, Yii::$app->request->post());
		    
		    foreach ($authors as $i => $author) {
		        $author->author_order = $i;
		    }
		    
		    
		    $valid = $model->validate();
		    if(!$valid){
		        $model->flashError();
		    }
		    $valid = Model::validateMultiple($authors) && $valid;
		   
		    if ($valid) {
		        
		        $transaction = Yii::$app->db->beginTransaction();
		        try {
		            
		            $model->updated_at = new Expression('NOW()');
		            $model->full_paper_at = new Expression('NOW()');
		            $model->status = 80; //full paper submission
		            if ($flag = $model->save(false)) {
		                
		                foreach ($authors as $i => $author) {
		                    if ($flag === false) {
		                        break;
		                    }
		                    //do not validate this in model
		                    $author->paper_id = $model->id;
		                    
		                    if (!($flag = $author->save(false))) {
		                        break;
		                    }
		                }
		                
		            }else{
		                
		                $model->flashError();
		            }
		            
		            if ($flag) {
		                $transaction->commit();
		                    Yii::$app->session->addFlash('success', "Thank you, your full paper has been successfully submitted");
		                    return $this->redirect(['member/index', 'confurl'=> $confurl]);

		                
		                
		            } else {
		                $transaction->rollBack();
		            }
		        } catch (Exception $e) {
		            $transaction->rollBack();
		            
		        }
		    }
		    
		    
		    
		    
		    
		}
		
		
		
		
		
        /* if ($model->load(Yii::$app->request->post())) {
            $model->updated_at = new Expression('NOW()'); 
			$model->full_paper_at = new Expression('NOW()');
			$model->status = 50; //full paper submission
			if($model->save()){
				Yii::$app->session->addFlash('success', "Thank you, your full paper has been successfully submitted.");
				return $this->redirect(['member/index', 'confurl' => $confurl]);
			}else{
				$model->flashError();
				return $this->redirect(['member/full-paper', 'confurl' => $confurl, 'id' => $id]);
				
			}
           
        } */
    }
    
     return $this->render('full-paper', [
            'model' => $model,
         'authors' => (empty($authors)) ? [new ConfAuthor] : $authors
        ]);
   
	}
	
	public function actionCorrection($confurl=null,$id){
		$conf = $this->findConferenceByUrl($confurl);
		if($conf->system_only == 1){
			$this->layout = 'system-member';
		}else{
			$this->layout = 'main-member';
		}

		
	    if($confurl){
	        $model = $this->findModel($id);
	        $model->scenario = 'correction';
	        
	        $review = PaperReviewer::findOne(['paper_id' => $id]);
	        
	        
	        $authors = $model->authors;
	        
	        
	        
	        if ($model->load(Yii::$app->request->post())) {
	            
	            $action = Yii::$app->request->post('action');
	           
	            
	            $model->updated_at = new Expression('NOW()');
	            
	            $oldIDs = ArrayHelper::map($authors, 'id', 'id');
	            
	            
	            $authors = Model::createMultiple(ConfAuthor::classname(), $authors);
	            
	            Model::loadMultiple($authors, Yii::$app->request->post());
	            
	            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($authors, 'id', 'id')));
	            
	            
	           
	            
	            foreach ($authors as $i => $author) {
	                $author->author_order = $i;
	            }
	            
	            
	            $valid = $model->validate();
	            if(!$valid){
	                $model->flashError();
	            }
	            $valid = Model::validateMultiple($authors) && $valid;
	            
	            if ($valid) {
	                
	                $transaction = Yii::$app->db->beginTransaction();
	                try {
	                    
	                    $model->updated_at = new Expression('NOW()');
	                    $model->full_paper_at = new Expression('NOW()');
	                    if($action == 'submit'){
	                        $model->status = 100; //full paper submission
	                    }
	                    
	                    if ($flag = $model->save(false)) {
	                        if (! empty($deletedIDs)) {
	                            ConfAuthor::deleteAll(['id' => $deletedIDs]);
	                        }
	                        
	                        foreach ($authors as $i => $author) {
	                            if ($flag === false) {
	                                break;
	                            }
	                            //do not validate this in model
	                            $author->paper_id = $model->id;
	                            
	                            if (!($flag = $author->save(false))) {
	                                break;
	                            }
	                        }
	                        
	                    }else{
	                        
	                        $model->flashError();
	                    }
	                    
	                    if ($flag) {
	                        $transaction->commit();
	                        if($action == 'submit'){
    	                        Yii::$app->session->addFlash('success', "Thank you, your full paper correction has been successfully submitted");
    	                        return $this->redirect(['member/index', 'confurl'=> $confurl]);
	                        }else{
	                            Yii::$app->session->addFlash('success', "Information Updated");
	                            return $this->refresh();
	                        }
	                        
	                        
	                        
	                    } else {
	                        $transaction->rollBack();
	                    }
	                } catch (Exception $e) {
	                    $transaction->rollBack();
	                    
	                }
	            }
	            
	            
	            
	            
	            
	        }
	        

	    }
	    
	    return $this->render('correction', [
	        'model' => $model,
	        'review' => $review,
	        'authors' => (empty($authors)) ? [new ConfAuthor] : $authors
	    ]);
	    
	}

    /**
     * Updates an existing ConfPaper model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
	public function actionUpdate($confurl=null,$id)
    {
		$conf = $this->findConferenceByUrl($confurl);
		if($conf->system_only == 1){
			$this->layout = 'system-member';
		}else{
			$this->layout = 'main-member';
		}

		if($confurl){
        $model = $this->findModel($id);
        $authors = $model->authors;
       
        if ($model->load(Yii::$app->request->post())) {
            
            $model->updated_at = new Expression('NOW()');
			$abstract_full = $model->form_abstract_only;
            
            $oldIDs = ArrayHelper::map($authors, 'id', 'id');
            
            
            $authors = Model::createMultiple(ConfAuthor::classname(), $authors);
            
            Model::loadMultiple($authors, Yii::$app->request->post());
            
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($authors, 'id', 'id')));
            
            foreach ($authors as $i => $author) {
                $author->author_order = $i;
            }
            
            
            $valid = $model->validate();
            
            $valid = Model::validateMultiple($authors) && $valid;
            
            if ($valid) {

                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (! empty($deletedIDs)) {
                            ConfAuthor::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($authors as $i => $author) {
                            if ($flag === false) {
                                break;
                            }
                            //do not validate this in model
                            $author->paper_id = $model->id;

                            if (!($flag = $author->save(false))) {
                                break;
                            }
                        }

                    }

                    if ($flag) {
                        $transaction->commit();
							if($abstract_full == 1){
								Yii::$app->session->addFlash('success', "Paper Information is updated");
								return $this->redirect(['member/index', 'confurl'=> $confurl]);
							}else if($abstract_full == 2){
								return $this->redirect(['member/upload', 'confurl'=> $confurl, 'id' => $model->id]);
							}
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    
                }
            }

        
        
       

    }
    
     return $this->render('abstract', [
            'model' => $model,
         'conf' => $conf,
            'authors' => (empty($authors)) ? [new ConfAuthor] : $authors
        ]);
   
	} 
	
	}


    /**
     * Deletes an existing ConfPaper model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ConfPaper model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ConfPaper the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ConfPaper::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	protected function findConferenceByUrl($url)
    {
        if (($model = Conference::findOne(['conf_url' => $url])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	

	public function actionUploadFile($attr, $id){
        $attr = $this->clean($attr);
        $model = $this->findModel($id);
        $model->file_controller = 'member';
        $conf = $model->conference;
        $confurl = $conf->conf_url;

        return UploadFile::upload($model, $attr, 'updated_at');

    }

	protected function clean($string){
        $allowed = ['paper', 'payment', 'repaper', 'fee'];
        
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
        $title = $model->filenameDownload;
        
        $filename = $id . '-' . strtolower($title);
        UploadFile::download($model, $attr, $filename);
    }
	
	public function actionDownloadConfFile($attr, $id, $identity = true){
        $attr = $this->clean($attr);
        $model = $this->findModel($id);
        $filename = strtoupper($attr) . ' ' . Yii::$app->user->identity->fullname;
        UploadFile::download($model, $attr, $filename);
    }
	
    /*	public function actionAcceptLetterPdf($id){
		$model = $this->findModel($id);
		$pdf = new AcceptLetterPdf;
		$pdf->model = $model;
		$pdf->generatePdf();
	}
	
 	public function actionInvoicePdf($id){
		$model = $this->findModel($id);
		$file = Yii::getAlias('@upload/' . $model->conference->logo_file);
		$random = '';
		$random = rand(1000000,100000000);
		$to = 'images/logo_'.$random.'.png';
		copy($file, $to);
		$pdf = new InvoicePdf;
		$pdf->logo = $to;
		$pdf->conf = $model->conference;
		$pdf->model = $model;
		$pdf->generatePdf();
		
		unlink($to);
		
	}
	
	public function actionReceiptPdf($id){
		$model = $this->findModel($id);
		$file = Yii::getAlias('@upload/' . $model->conference->logo_file);
		$random = '';
		$random = rand(1000000,100000000);
		$to = 'images/logo_'.$random.'.png';
		copy($file, $to);
		$pdf = new ReceiptPdf;
		$pdf->logo = $to;
		$pdf->conf = $model->conference;
		$pdf->model = $model;
		$pdf->generatePdf();
		
		unlink($to);
		
	} */


}
