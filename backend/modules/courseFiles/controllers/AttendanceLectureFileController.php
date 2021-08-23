<?php

namespace backend\modules\courseFiles\controllers;

use backend\modules\teachingLoad\models\CourseLecture;
use common\models\UploadFile;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\db\Expression;


/**
 * Default controller for the `course-files` module
 */
class AttendanceLectureFileController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
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
    
    public function actionUploadFile($attr, $id){
        $attr = $this->clean($attr);
        $model = $this->findModel($id);
        
        $model->progressStudentAttendance = 1;
        
        $model->file_controller = 'attendance-lecture-file';
        
        $path = 'course-files/'.$model->courseOffered->semester_id.'/'.$model->courseOffered->course->course_code.'/'.$model->lec_name.'/9-attendance';
        
        return UploadFile::upload($model, $attr, 'updated_at', $path);
        
    }
    
    protected function clean($string){
        $allowed = ['attendance'];
        
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
        $model->progressStudentAttendance = 0;
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
        $filename = $attr;
        
        UploadFile::download($model, $attr, $filename);
    }
    
    protected function findModel($id)
    {
        if (($model = CourseLecture::findOne($id)) !== null) {
            return $model;
        }
        
        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	
}
