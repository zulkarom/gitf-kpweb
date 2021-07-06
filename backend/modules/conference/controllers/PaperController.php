<?php

namespace backend\modules\conference\controllers;

use Yii;
use backend\modules\conference\models\ConfPaper;
use backend\modules\conference\models\ConfAuthor;
use backend\modules\conference\models\pdf\InvoicePdf;
use backend\modules\conference\models\pdf\AcceptLetterPdf;
use backend\modules\conference\models\AbstractSearch;
use backend\modules\conference\models\FullPaperSearch;
use backend\modules\conference\models\PaymentSearch;
use backend\modules\conference\models\RejectSearch;
use backend\modules\conference\models\ReviewSearch;
use backend\modules\conference\models\OverwriteSearch;
use backend\modules\conference\models\CompleteSearch;
use backend\modules\conference\models\PaperAcceptForm;
use backend\modules\conference\models\PaperReviewerForm;
use backend\modules\conference\models\PaperRejectForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\conference\models\UploadPaperFile as UploadFile;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use common\models\Model;
use yii\filters\AccessControl;
use backend\modules\conference\models\CorrectionSearch;
use backend\modules\conference\models\PaperReviewer;


/**
 * PaperController implements the CRUD actions for ConfPaper model.
 */
class PaperController extends Controller
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


    /**
     * Lists all ConfPaper models.
     * @return mixed
     */
    public function actionAbstract($conf)
    {
        $searchModel = new AbstractSearch();
		$searchModel->conf_id = $conf;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('abstract', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionFullPaper($conf)
    {
        $searchModel = new FullPaperSearch();
		$searchModel->conf_id = $conf;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('full-paper', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionComplete($conf)
    {
        $searchModel = new CompleteSearch();
		$searchModel->conf_id = $conf;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('complete', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionReject($conf)
    {
        $searchModel = new RejectSearch();
        $searchModel->conf_id = $conf;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('reject', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionPayment($conf)
    {
        $searchModel = new PaymentSearch();
		$searchModel->conf_id = $conf;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('payment', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionReview($conf)
    {
        $searchModel = new ReviewSearch();
		$searchModel->conf_id = $conf;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('review', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    
    public function actionReviewerView($conf, $id)
    {
        $model = $this->findModel($id);
        $review = $this->findPaperReviewer($id);
        
        return $this->render('review-view', [
            'model' => $model,
            'review' => $review,
        ]);
    }
    
    public function actionCorrection($conf)
    {
        $searchModel = new CorrectionSearch();
        $searchModel->conf_id = $conf;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('correction', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
	
	public function actionOverview($conf)
    {
        $searchModel = new OverwriteSearch();
		$searchModel->conf_id = $conf;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('overview', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'conf' => $conf
        ]);
    }
	
	public function actionOverwriteForm($conf, $id){
		if($conf){
        $model = $this->findModel($id);
        $authors = $model->authors;
       
        if ($model->load(Yii::$app->request->post())) {
            
            $model->updated_at = new Expression('NOW()');
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
							Yii::$app->session->addFlash('success', "Paper Information is updated");
							return $this->redirect(['paper/overview', 'conf'=> $conf]);
                    } else {
                        $transaction->rollBack();
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    
                }
            }

        
        
       

    }
    
     return $this->renderAjax('overwrite-form', [
            'model' => $model,
            'authors' => (empty($authors)) ? [new ConfAuthor] : $authors
        ]);
   
	} 
	}

    /**
     * Displays a single ConfPaper model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionAbstractView($conf, $id)
    {
		
		$model = $this->findModel($id);
		$reject = PaperRejectForm::findOne($id);
		$accept = PaperAcceptForm::findOne($id);
		
		$reject->scenario = 'reject';

        
        if ($reject->load(Yii::$app->request->post())) {
            $reject->status = 10;
            if($reject->save()){
                Yii::$app->session->addFlash('success', "Paper Rejected successfully");
                return $this->redirect(['paper/reject', 'conf' => $conf]);
            }
        }
        
        
        
        if ($accept->load(Yii::$app->request->post())) {
            $accept->status = 40;//abstract accepted
            if($accept->save()){
                Yii::$app->session->addFlash('success', "Abstract Accepted successfully");
                return $this->redirect(['paper/abstract', 'conf' => $conf]);
            }else{
                $accept->flashError();
            }
        }
		
        return $this->render('abstract-view', [
            'model' => $model,
            'reject' => $reject,
            'accept' => $accept,
        ]);
    }
	
	public function actionInvoiceView($conf, $id)
    {
		
		$model = $this->findModel($id);
		
        return $this->render('invoice-view', [
            'model' => $model,
        ]);
    }
	
	public function actionPaymentView($conf, $id)
    {
		
		$model = $this->findModel($id);
		
		if ($model->load(Yii::$app->request->post())) {
			$option = Yii::$app->request->post('wfaction');
			if($option == 1){
				$model->status = 100;//paper accepted
				$model->receipt_ts = time();
				$model->receipt_confly_no = $model->nextReceiptConflyNumber();
			}else if($option == 0){
				$model->status = 95;//rejected
			}
			
			if($model->save()){
				return $this->redirect(['paper/payment', 'conf' => $conf]);
			}
            
        }
		
        return $this->render('payment-view', [
            'model' => $model,
        ]);
    }
	
	public function actionChangeReviewer($conf, $id)
    {
		
		$model = $this->findModel($id);
		$reviewer = PaperReviewerForm::findOne($id);
		$reviewer ->scenario = 'assign_reviewer';

		if ($reviewer->load(Yii::$app->request->post())) {
			$reviewer->status = 60;
			
			$slot = PaperReviewer::findOne(['paper_id' => $reviewer->id]);
			if($slot){
			    $slot->user_id = $reviewer->reviewer_user_id;
			}else{
			    $slot = new PaperReviewer();
			    $slot->scenario = 'create';
			    $slot->user_id = $reviewer->reviewer_user_id;
			    $slot->paper_id = $reviewer->id;
			}
			
			if($slot->save() and $reviewer->save()){
				Yii::$app->session->addFlash('success', "Reviewer assigned successfully");
				return $this->redirect(['paper/review', 'conf' => $conf]);
			}
		}
		
		
        return $this->render('change-reviewer', [
            'model' => $model,
			'reviewer' => $reviewer,
        ]);
    }
	
	public function actionFullPaperView($conf, $id)
    {
		
		$model = $this->findModel($id);
		$conference = $model->conference;
		$commercial = $conference->commercial == 1 ? true : false;
		
		//all these extent from paper model
		$reviewer = PaperReviewerForm::findOne($id);
		$reject = PaperRejectForm::findOne($id);
		$accept = PaperAcceptForm::findOne($id);
		
		$reviewer ->scenario = 'assign_reviewer';
		$reject->scenario = 'reject';
		$accept->scenario = 'accept_full';
		
		
		
		if ($reviewer->load(Yii::$app->request->post())) {
		   // print_r(Yii::$app->request->post());die();
		   
		    
			$reviewer->status = 60; //paper correcttion
			
			//process review slot
			$slot = PaperReviewer::findOne(['paper_id' => $reviewer->id]);
			
			if($slot){
			    $slot->user_id = $reviewer->reviewer_user_id;
			}else{
			    $slot = new PaperReviewer();
			    $slot->scenario = 'create';
			    $slot->user_id = $reviewer->reviewer_user_id;
			    $slot->paper_id = $reviewer->id;
			}
			
			if($slot->save() and $reviewer->save()){
				Yii::$app->session->addFlash('success', "Reviewer assigned successfully");
				return $this->redirect(['paper/review', 'conf' => $conf]);
			}
		}
		
		if ($reject->load(Yii::$app->request->post())) {
			$reject->status = 10;
			if($reject->save()){
				Yii::$app->session->addFlash('success', "Paper Rejected successfully");
				return $this->redirect(['paper/reject', 'conf' => $conf]);
			}
		}
		
		if ($accept->load(Yii::$app->request->post())) {
			
			if($commercial){
				$accept->status = 80;
				$accept->invoice_confly_no = $model->nextInvoiceConflyNumber();
				$accept->invoice_ts = time();
				$accept->fp_accept_ts = time();
			}else{
				$accept->status = 100;
			}
			if($accept->save()){
				Yii::$app->session->addFlash('success', "Paper Accepted successfully");
				if($commercial){
					return $this->redirect(['paper/payment', 'conf' => $conf]);
				}else{
					return $this->redirect(['paper/complete', 'conf' => $conf]);
				}
				
			}else{
				$accept->flashError();
			}
		}
		
        return $this->render('full-paper-view', [
            'model' => $model,
			'reject' => $reject,
			'reviewer' => $reviewer,
			'accept' => $accept,
        ]);
    }
	
	public function actionCompleteView($conf, $id)
    {
		
		$model = $this->findModel($id);
		
		if ($model->load(Yii::$app->request->post())) {
			/* $option = $model->abstract_decide;
			if($option == 1){
				$model->status = 80;//paper accepted
				$model->invoice_ts = time();
			}else if($option == 0){
				$model->status = 10;//rejected
			}
			if($model->save()){
				return $this->redirect(['paper/complete', 'conf' => $conf]);
			} */
            
        }
		
        return $this->render('complete-view', [
            'model' => $model,
        ]);
    }
    
    public function actionRejectView($conf, $id)
    {
        
        $model = $this->findModel($id);
        $review = $this->findPaperReviewer($id);
        
        return $this->render('reject-view', [
            'model' => $model,
            'review' => $review,
        ]);
    }
	
	public function actionAcceptLetterPdf($id){
		
		$model = $this->findModel($id);
		$file = Yii::getAlias('@upload/' . $model->conference->logo_file);
		$random = '';
		$random = rand(1000000,100000000);
		$to = 'images/logo_'.$random.'.png';
		copy($file, $to);
		$pdf = new AcceptLetterPdf;
		$pdf->logo = $to;
		$pdf->conf = $model->conference;
		$pdf->model = $model;
		$pdf->generatePdf();
		
		unlink($to);
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

    /**
     * Creates a new ConfPaper model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ConfPaper();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ConfPaper model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
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
        $paper = $this->findModel($id);
        $conf = $paper->conf_id;
        ConfAuthor::deleteAll(['paper_id' => $id]);
        PaperReviewer::deleteAll(['paper_id' => $id]);
        $paper->delete();
        Yii::$app->session->addFlash('success', "Paper Deleted");

        return $this->redirect(['overview','conf' => $conf]);
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
    
    protected function findPaperReviewer($id)
    {
        if (($model = PaperReviewer::findOne(['paper_id' => $id])) !== null) {
            return $model;
        }
    }
    
    protected function findReviewModel($id)
    {
        if (($model = PaperReviewer::findOne($id)) !== null) {
            return $model;
        }
        
        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
	
	public function actionDownloadFile($attr, $id, $identity = true){
        $attr = $this->clean($attr);
        $model = $this->findModel($id);
        $id = $model->confly_number;
        $title = $model->filenameDownload;
        
        $filename = $id . '-' . strtolower($title);
        
        
        
        UploadFile::download($model, $attr, $filename);
    }
    
    public function actionDownloadReviewedFile($id, $attr, $identity = true){
        $attr = $this->clean($attr);
        $model = $this->findReviewModel($id);
        $paper = $model->paper;
        
        $filename = 'Review Paper ' . $paper->confly_number;
        UploadFile::download($model, $attr, $filename);
    }
	
	protected function clean($string){
        $allowed = ['paper', 'payment', 'reviewed'];
        
        foreach($allowed as $a){
            if($string == $a){
                return $a;
            }
        }
        
        throw new NotFoundHttpException('Invalid Attribute');

    }
}
