<?php

namespace backend\modules\teachingLoad\controllers;


use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\db\Expression;
use yii\filters\AccessControl;
use backend\modules\teachingLoad\models\AppointmentLetter;
use backend\modules\teachingLoad\models\AppointmentLetterFile;
use common\models\UploadFile;
use yii\helpers\Json;

class AppointmentLetterController extends Controller
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

    public function actionPdf($id){
        $model = $this->findModel($id);
        $pdf = new AppointmentLetterFile;
        $pdf->model = $model;
        $pdf->generatePdf();
        exit;
    }
    
    public function actionUpload($id){
        $model = $this->findModel($id);
        return $this->render('upload',[
            'model' => $model
        ]);
    }

    protected function findModel($id)
    {
        if (($model = AppointmentLetter::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    

    
    public function actionUploadFile($attr, $id){
        $attr = $this->clean($attr);
        $model = $this->findModel($id);
        $model->file_controller = 'appointment-letter';
        
        $path = 'course-files/'.$model->courseOffered->semester_id.'/appoint-letter-manual' ;
        
        $model->manual_file = 1;
        $model->setProgressAppointment();
        
        return UploadFile::upload($model, $attr, 'updated_at', $path);
        
    }
    
    
    public function actionAppointmentProgress($id){
        $model = $this->findModel($id);
        $model->setProgressAppointment();
        if($model->save()){
            if(empty($model->manual_file)){
                Yii::$app->session->addFlash('error', "Appointment letter file has not been uploaded!");
            }else{
                Yii::$app->session->addFlash('success', "Data Updated");
            }
            return $this->redirect(['/teaching-load/staff-inv/generate-reference']);
        }
    }
    
    protected function clean($string){
        $allowed = ['manual'];
        
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
        $filename = 'appointment-letter';
        
        
        
        UploadFile::download($model, $attr, $filename);
    }
    
    

}