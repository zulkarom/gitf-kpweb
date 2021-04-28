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
use backend\modules\conference\models\OverwriteSearch;
use backend\modules\conference\models\CompleteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\conference\models\UploadPaperFile as UploadFile;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use common\models\Model;
use yii\filters\AccessControl;


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
		
		if ($model->load(Yii::$app->request->post())) {
			$option = $model->abstract_decide;
			if($option == 1){
				$model->status = 40;//abstract accepted
			}else{
				$model->status = 10;//rejected
			}
			if($model->save()){
				return $this->redirect(['paper/abstract', 'conf' => $conf]);
			}
            
        }
		
        return $this->render('abstract-view', [
            'model' => $model,
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
	
	public function actionFullPaperView($conf, $id)
    {
		
		$model = $this->findModel($id);
		
		if ($model->load(Yii::$app->request->post())) {
			$option = $model->abstract_decide;
			
			if($option == 1){
				$action = Yii::$app->request->post('wfaction');
				//save?
				if($action == 'accept'){
					$model->status = 80;//paper accepted
					$model->invoice_confly_no = $model->nextInvoiceConflyNumber();
					$model->invoice_ts = time();
					$model->fp_accept_ts = time();
					if($model->save()){
						Yii::$app->session->addFlash('success', "Full paper accepted & Invoice issued successfully");
						return $this->redirect(['paper/full-paper', 'conf' => $conf]);
					}
				}else{
					$model->invoice_ts = time();
					if($model->save()){
						Yii::$app->session->addFlash('success', "Data Updated");
						return $this->redirect(['paper/full-paper-view', 'conf' => $conf, 'id' => $id]);
					}
				}
				
				
			}else if($option == 0){
				$model->status = 10;//rejected
				if($model->save()){
					return $this->redirect(['paper/full-paper', 'conf' => $conf]);
				}
			}
			
            
        }
		
        return $this->render('full-paper-view', [
            'model' => $model,
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
	
	public function actionDownloadFile($attr, $id, $identity = true){
        $attr = $this->clean($attr);
        $model = $this->findModel($id);
        $filename = strtoupper($attr) . ' ' . Yii::$app->user->identity->fullname;
        
        
        
        UploadFile::download($model, $attr, $filename);
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
}
