<?php

namespace backend\modules\aduan\controllers;

use Yii;
use backend\modules\aduan\models\Aduan;
use backend\modules\aduan\models\AduanTopic;
use backend\modules\aduan\models\AduanSearch;
use backend\modules\aduan\models\AduanAction;
use backend\modules\aduan\models\Setting;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\db\Expression;
use yii\filters\AccessControl;


/**
 * AduanController implements the CRUD actions for Aduan model.
 */
class AduanController extends Controller
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
     * Lists all Aduan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AduanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Aduan model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        
        $action =  AduanAction::find()->where(['aduan_id' => $id])->all();
        $actionCreate = new AduanAction();
        $aduan = $this->findModel($id);
		$aduan->scenario = 'admin_update';
        
        if ($actionCreate->load(Yii::$app->request->post()) && $aduan->load(Yii::$app->request->post())) {
            $post = $actionCreate->load(Yii::$app->request->post());
            $actionCreate->aduan_id = $id;
            $actionCreate->created_at = new Expression('NOW()'); 
            $actionCreate->created_by = Yii::$app->user->identity->id;
			$actionCreate->progress_id = $aduan->progress_id;
			
            if($actionCreate->save() and $aduan->save()){
				if($actionCreate->progress_id == 90){
					$actionCreate->sendActionEmail();
				}
				if($actionCreate->progress_id == 90){
					$actionCreate->sendActionEmail();
				}
				
				
				Yii::$app->session->addFlash('success', "Data Updated");
				return $this->refresh();
			}else{
				$actionCreate->flashError();
				$aduan->flashError();
			}
            
        }

        return $this->render('view', [
            'model' => $aduan,
            'action' => $action,
            'actionCreate' => $actionCreate,

        ]);
    }

    /**
     * Creates a new Aduan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Aduan();
        $modelAction = new AduanAction();
		
        if ($model->load(Yii::$app->request->post())) {
            $model->progress_id = 30;
            $model->created_at = new Expression('NOW()'); 
			$model->updated_at = new Expression('NOW()'); 
			$random = Yii::$app->security->generateRandomString();
			$model->token = $random;
			$code = rand(1000,9999);
			$model->email_code = $code;
			if($model->save()){
				Yii::$app->session->addFlash('success', "Aduan telah berjaya dihantar.");
				if(!$model->upload()){
					Yii::$app->session->addFlash('error', "Fail lampiran gagal dimuatnaik");
				}
				return $this->redirect(['index']);
				
			}else{
				$model->flashError();
			}
            
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionDownload($id){
        $model = $this->findModel($id);
        $model->download();
    }
	
	public function actionSetting(){
		$model = Setting::findOne(1);
		 if ($model->load(Yii::$app->request->post())) {
			 if($model->save()){
				 Yii::$app->session->addFlash('success', "Data Updated");
				 return $this->refresh();
			 }
		 }
		return $this->render('setting', [
            'model' => $model,
        ]);
	}

    

    /**
     * Updates an existing Aduan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    /* public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $oldfile = $model->upload_url;
            if($oldfile != ""){
                unlink(Yii::$app->basePath . '/web/upload/' . $oldfile);
            }

            $uploadFile = UploadedFile::getInstance($model,'upload_url');
            
            $model->upload_url = $uploadFile->name; 

            $model->save(false);

            $uploadFile->saveAs(Yii::$app->basePath . '/web/upload/' . $uploadFile->name);

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    } */

  

    /**
     * Deletes an existing Aduan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $oldfile = $model->upload_url;
        unlink(Yii::$app->basePath . '/web/upload/' . $oldfile);
        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Aduan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Aduan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Aduan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	public function actionStats(){
		$model = new Aduan;
		return $this->render('stats', [
            'model' => $model,
        ]);
	}
}
