<?php

namespace confsite\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\db\Exception;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use common\models\Model;
use backend\modules\conference\models\ConfPaper;
use backend\modules\conference\models\ConfAuthor;
use backend\modules\conference\models\Conference;
use backend\modules\conference\models\PaperReviewer;
use confsite\models\UploadReviewerFile as UploadFile;
use confsite\models\ReviewSearch;

/**
 * PaperController implements the CRUD actions for ConfPaper model.
 */
class ReviewerController extends Controller
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
			$conf = $this->findConferenceByUrl($url);
			if(!Conference::userIsRegistered($conf->id)){
				return $this->redirect(['site/member', 'confurl' => $url])->send();
			}else{
				return true;
			}
			
		}
	}
	
	
	public function actionIndex($confurl=null)
    {
		
	}

	
	public function actionReview($confurl=null)
    {
		$this->layout = 'main-member';
		$conf = $this->findConferenceByUrl($confurl);
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
		if($confurl){
        $model = $this->findModel($id);
		$review = $this->findReviewer($id);
		/* if($review->status == 20){
			return $this->redirect(['review/review-completed', 'id' => $id]);
		} */
		
		if($review->load(Yii::$app->request->post())){
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
					$model->sendReviewerEmail(Yii::$app->user->identity, 'Appreciate-reviewer');
					
					//if no other in progress
					if(!$model->checkInProgressReviewers()){
						$model->sendEmail('After-all-reviewers-finished');
					}
					Yii::$app->session->addFlash('success', "Thank you, your review has been successfully submitted.");
					return $this->redirect('index');
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
	

	

	


    /**
     * Updates an existing ConfPaper model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
	public function actionUpdate($confurl=null,$id)
    {
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
            'authors' => (empty($authors)) ? [new ConfAuthor] : $authors
        ]);
   
	} 
	
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
    
    protected function findReviewModel($id)
    {
        if (($model = PaperReviewer::findOne($id)) !== null) {
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
        $model = $this->findReviewModel($id);
        $model->file_controller = 'reviewer';

        return UploadFile::upload($model, $attr);

    }

	protected function clean($string){
        $allowed = ['reviewed', 'payment'];
        
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
        $model = $this->findReviewModel($id);
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
        $model = $this->findReviewModel($id);
        $paper = $model->paper;
        
        $filename = 'Review Paper ' . $paper->confly_number;
        UploadFile::download($model, $attr, $filename);
    }
	
	public function actionDownloadConfFile($attr, $id, $identity = true){
        $attr = $this->clean($attr);
        $model = $this->findModel($id);
        $filename = strtoupper($attr) . ' ' . Yii::$app->user->identity->fullname;
        UploadFile::download($model, $attr, $filename);
    }
	
}
