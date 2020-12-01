<?php

namespace backend\modules\chapterinbook\controllers;

use Yii;
use backend\modules\chapterinbook\models\Paper;
use backend\modules\chapterinbook\models\PaperSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\UploadFile;
use yii\helpers\Json;
use yii\db\Expression;
 use yii\filters\AccessControl;

/**
 * ProjectController implements the CRUD actions for Paper model.
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
     * Lists all Paper models.
     * @return mixed
     */
    public function actionIndex($proc)
    {
        $searchModel = new PaperSearch();
		$searchModel -> proceeding = $proc;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'proc' => $proc,
        ]);
    }

    /**
     * Displays a single Paper model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $proc)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
			'proc' => $proc,
        ]);
    }

    /**
     * Creates a new Paper model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($proc)
    {
        $model = new Paper();

        if ($model->load(Yii::$app->request->post()) ) {
           $model ->chap_id = $proc;
		   $model->save();
		   $action = Yii::$app->request->post('btn-submit');
		   if($action == 'Next'){
			   return $this->redirect(['update', 'id' => $model->id ,'proc' => $proc]);
		   }else{
			   return $this->redirect(['index', 'proc' => $proc]);
		   }
		   
        }

        return $this->render('create', [
            'model' => $model,
			'proc' => $proc,
        ]);
    }

    /**
     * Updates an existing Paper model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $proc)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'proc' => $proc]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Paper model.
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
     * Finds the Paper model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Paper the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Paper::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	

public function actionUploadFile($attr, $id){
        $attr = $this->clean($attr);
        $model = $this->findModel($id);
        $model->file_controller = 'paper';
		$path = 'chapterinbook/' . $model->chapterinbook->chap_url;
        return UploadFile::upload($model, $attr, 'updated_at', $path);

    }

protected function clean($string){
        $allowed = ['paper'];
        
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


}
