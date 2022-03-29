<?php

namespace backend\modules\courseFiles\controllers;

use Yii;
use yii\db\Expression;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use common\models\UploadFile;
use yii\helpers\Json;
use backend\modules\teachingLoad\models\AppointmentLetter;


class AppointmentController extends Controller
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
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
	
    }

 
	
	public function actionUploadFile($attr, $id){

        $attr = $this->clean($attr);
        $model = $this->findModel($id);
        $model->file_controller = 'appointment';
		$course = $model->courseOffered->course;
		
		$path = 'course-files/'.$model->courseOffered->semester_id.'/'.$course->course_code.'/'.$model->staffInvolved->staff->staff_no ;
		$model->steva_file = 1;
		$model->setProgressAppointment();

        return UploadFile::upload($model, $attr, 'updated_at', $path);

    }
	
    public function actionAppointmentProgress($id, $c = false, $m = false, $offer = false){
		$model = $this->findModel($id);
		$model->setProgressAppointment();
		if($model->save()){
			if(empty($model->steva_file)){
				Yii::$app->session->addFlash('error', "No student evaluation file has been uploaded!");
			}else{
				Yii::$app->session->addFlash('success', "Data Updated");
			}
			
			if($c && $m && $offer){
			    return $this->redirect([$c. '/' . $m, 'id' => $offer]);
			}
			return $this->redirect(['default/teaching-assignment']);
		}
	}
	
	protected function findModel($id)
    {
        if (($model = AppointmentLetter::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

	protected function clean($string){
		$allowed = ['steva'];
        if(in_array($string,$allowed)){
            return $string;
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
		$model->setProgressAppointment();
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
