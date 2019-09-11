<?php

namespace backend\modules\erpd\controllers;

use Yii;
use backend\modules\erpd\models\Membership;
use backend\modules\erpd\models\MembershipSearch;
use backend\modules\erpd\models\MembershipAllSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Upload;
use yii\helpers\Json;
use yii\db\Expression;

/**
 * MembershipController implements the CRUD actions for Membership model.
 */
class MembershipController extends Controller
{
    /**
     * @inheritdoc
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
     * Lists all Membership models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MembershipSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
    public function actionAll()
    {
        $searchModel = new MembershipAllSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('all', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Membership model.
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
	
	public function actionViewVerify($id)
    {
		$model = $this->findModel($id);
		if ($model->load(Yii::$app->request->post())) {
			$model->reviewed_at = new Expression('NOW()');
			$model->reviewed_by = Yii::$app->user->identity->id;
			$status = Yii::$app->request->post('wfaction');
			if($status == 'correction'){
				$model->status = 10;
			}else if($status == 'verify'){
				$model->status = 50;
			}
			if($model->save()){
				Yii::$app->session->addFlash('success', "Data Updated");
			}
		}
		
        return $this->render('view-verify', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Membership model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Membership();

        if ($model->load(Yii::$app->request->post())) {
			$model->msp_staff = Yii::$app->user->identity->staff->id;
			$model->created_at = new Expression('NOW()');
			
			
			if($model->save()){
				 $action = Yii::$app->request->post('wfaction');
				if($action == 'save'){
					Yii::$app->session->addFlash('success', "Data saved");
					return $this->redirect(['/erpd/membership/update', 'id' => $model->id]);
				}else if($action == 'next'){
					return $this->redirect(['/erpd/membership/upload', 'id' => $model->id]);
				}
			}else{
				$model->flashError();
			}
           
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Membership model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
			$model->modified_at = new Expression('NOW()');
			if(Yii::$app->request->post('check-end')){
				$model->date_end = '0000-00-00';
			}

			if($model->save()){
				$action = Yii::$app->request->post('wfaction');
				if($action == 'save'){
					Yii::$app->session->addFlash('success', "Data saved");
					return $this->redirect(['/erpd/membership/update', 'id' => $model->id]);
				}else if($action == 'next'){
					return $this->redirect(['/erpd/membership/upload', 'id' => $model->id]);
				}
			}
            
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Membership model.
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
     * Finds the Membership model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Membership the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Membership::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	public function actionUpload($id){
		$model = $this->findModel($id);
		if($model->status > 20 ){
			return $this->redirect(['view', 'id' => $id]);
		}
		$model->scenario = 'submit';
		
		if ($model->load(Yii::$app->request->post())) {
			$model->modified_at = new Expression('NOW()');
			if($model->status == 10){
				$model->status = 30;//updated
			}else{
				$model->status = 20;//submit
			}
			
			if($model->save()){
				Yii::$app->session->addFlash('success', "Your membership has been successfully submitted.");
				return $this->redirect('index');
			}else{
				$model->flashError();
			}
		}
		
		 return $this->render('upload', [
            'model' => $model,
        ]);
	}
	
	public function actionUploadFile($attr, $id){
        $attr = $this->clean($attr);
        $model = $this->findModel($id);
        $model->file_controller = 'membership';

        return Upload::upload($model, $attr, 'modified_at');

    }

	protected function clean($string){
		$allowed = ['msp'];
		
		foreach($allowed as $a){
			if($string == $a){
				return $a;
			}
		}
		
		throw new NotFoundHttpException('The requested page does not exist.');
    }

	public function actionDeleteFile($attr, $id)
    {
        $attr = $this->clean($attr);
        $model = $this->findModel($id);
        $attr_db = $attr . '_file';
        
        $file = Yii::getAlias('@upload/' . $model->{$attr_db});
        
        $model->scenario = $attr . '_delete';
        $model->{$attr_db} = '';
        $model->modified_at = new Expression('NOW()');
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
        
        
        
        Upload::download($model, $attr, $filename);
    }
}
