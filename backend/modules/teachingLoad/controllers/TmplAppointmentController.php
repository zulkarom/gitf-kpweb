<?php

namespace backend\modules\teachingLoad\controllers;

use Yii;
use backend\modules\teachingLoad\models\TmplAppointment;
use backend\modules\teachingLoad\models\TmplAppointmentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\db\Expression;
use yii\helpers\Json;
use common\models\Upload;
use common\models\UploadFile;

/**
 * TmplAppointmentController implements the CRUD actions for TmplAppointment model.
 */
class TmplAppointmentController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all TmplAppointment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TmplAppointmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TmplAppointment model.
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
     * Creates a new TmplAppointment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $new = new TmplAppointment();
        $model = $this->findModel($id);
        
        $colums = ['template_name',
            'dekan',
            'yg_benar',
            'tema',
            'per1',
            'per1_en',
            'signiture_file',
            'adj_y',
            'is_computer',
            'background_file'];
        
        foreach($colums as $col){
            $new->$col = $model->$col;
        }
        
        $new->updated_at = new Expression('NOW()');
        $new->created_at = new Expression('NOW()');
        
        if($new->save()){
            Yii::$app->session->addFlash('success', "The new template has been copied.");
            return $this->redirect(['update', 'id' => $new->id]);
        }

    }

    /**
     * Updates an existing TmplAppointment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->updated_at = new Expression('NOW()');


            if($model->save()){
                Yii::$app->session->addFlash('success', "Template Updated");
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TmplAppointment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDeletex($id)
    {
       
    }

    /**
     * Finds the TmplAppointment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TmplAppointment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TmplAppointment::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionUploadFile($attr, $id){
        $attr = $this->clean($attr);
        $model = $this->findModel($id);
        $model->file_controller = 'tmpl-appointment';
        $path = 'signiture/' . Yii::$app->user->identity->username ;

        return UploadFile::upload($model, $attr, 'updated_at',$path);

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
                //unlink($file);
                
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
        $filename = strtoupper($attr) ;
        UploadFile::download($model, $attr, $filename);
    }
    
    protected function clean($string){
        if(in_array($string, ['signiture'])){
            return $string;
        }
        return false;
    }
    
}
