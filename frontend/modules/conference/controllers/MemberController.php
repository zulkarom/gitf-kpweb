<?php

namespace frontend\modules\conference\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use common\models\Model;
use common\models\User;
use backend\modules\conference\models\ConfPaper;
use backend\modules\conference\models\ConfAuthor;
use backend\modules\conference\models\Conference;
use backend\modules\conference\models\pdf\InvoicePdf;
use backend\modules\conference\models\pdf\ReceiptPdf;
use backend\modules\conference\models\pdf\AcceptLetterPdf;
use backend\modules\conference\models\UploadPaperFile as UploadFile;
use frontend\modules\conference\models\ConfPaperSearch;

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
		return $this->redirect(['member/paper', 'confurl' => $confurl]);
	}

    /**
     * Lists all ConfPaper models.
     * @return mixed
     */
    public function actionPaper($confurl=null)
    {
		$this->layout = 'main-member';
		$conf = $this->findConferenceByUrl($confurl);
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
		$this->layout = 'main-member';
		$conf = $this->findConferenceByUrl($confurl);
        $searchModel = new ConfPaperSearch();
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
	
	public function actionPayment($confurl=null)
    {
		$this->layout = 'main-member';
		
		if($confurl){
			return $this->render('payment', [
			]);
		}
        
    }
	
	public function actionInvoiceView($confurl=null, $id)
    {
		$this->layout = 'main-member';
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
		$this->layout = 'main-member';
        $model = $this->findModel($id);
		if($confurl){
			
			return $this->render('complete-view', [
				'model' => $model
			]);
		}
        
    }
	
	public function actionProfile($confurl=null)
    {
		$this->layout = 'main-member';
		
		if($confurl){
			$user = User::findOne(Yii::$app->user->identity->id);
			
			if ($user->load(Yii::$app->request->post()) && $user->associate->load(Yii::$app->request->post())) {
			
			if($user->save() && $user->associate->save()){
				Yii::$app->session->addFlash('success', "Profile Updated");
				return $this->redirect(['member/profile', 'confurl' => $confurl]);
			}
			
			}
			
			
			return $this->render('profile', [
			'user' => $user
			]);
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
            
            $valid = Model::validateMultiple($authors) && $valid;
            
            if ($valid) {

                $transaction = Yii::$app->db->beginTransaction();
                try {
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
            'authors' => (empty($authors)) ? [new ConfAuthor] : $authors
        ]);
   
	} 
	
	}
	
	public function actionUpload($confurl=null,$id){
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
		if($confurl){
        $model = $this->findModel($id);
		$model->scenario = 'fullpaper';
        if ($model->load(Yii::$app->request->post())) {
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
           
        }
    }
    
     return $this->render('full-paper', [
            'model' => $model
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

        return UploadFile::upload($model, $attr, 'updated_at');

    }

	protected function clean($string){
        $allowed = ['paper', 'payment'];
        
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
	
	public function actionDownloadConfFile($attr, $id, $identity = true){
        $attr = $this->clean($attr);
        $model = $this->findModel($id);
        $filename = strtoupper($attr) . ' ' . Yii::$app->user->identity->fullname;
        UploadFile::download($model, $attr, $filename);
    }
	
	public function actionAcceptLetterPdf($id){
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
		
	}


}
