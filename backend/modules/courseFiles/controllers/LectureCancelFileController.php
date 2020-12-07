<?php

namespace backend\modules\courseFiles\controllers;

use Yii;
use yii\web\Controller;
use backend\modules\courseFiles\models\LectureCancelFile;
use backend\modules\teachingLoad\models\CourseLecture;
use yii\filters\AccessControl;
use yii\db\Expression;
use yii\web\NotFoundHttpException;
use common\models\UploadFile;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * Default controller for the `course-files` module
 */
class LectureCancelFileController extends Controller
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
    
    public function actionPage($id)
    {
        $model = $this->findLecture($id);
        
        return $this->render('/lecture-test/class-cancel-upload', [
            'model' => $model,
        ]);
    }
    
    protected function findLecture($id)
    {
        if (($model = CourseLecture::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionAdd($id){
        
        $model = new LectureCancelFile;
        $model->scenario = 'add_cancel';
        
        $model->lecture_id = $id;
        $model->updated_at = new Expression('NOW()');
        
        if(!$model->save()){
            $model->flashError();
        }
        
        return $this->redirect(['page', 'id' => $id]);
    }
    
    public function actionDeleteRow($id){
        $model = $this->findLectureCancel($id);
        if($model->delete()){
            return $this->redirect(['page', 'id' => $model->lecture_id]);
        }
    }
    
    public function actionUploadFile($attr, $id){
        $attr = $this->clean($attr);
        $model = $this->findLectureCancel($id);
        $model->file_controller = 'lecture-cancel-file';
        $path = 'course-files/'.$model->lecture->courseOffered->semester_id.'/'.$model->lecture->courseOffered->course->course_code.'/'.$model->lecture->lec_name.'/10-class-cancellation';
        return UploadFile::upload($model, $attr, 'updated_at', $path);

    }
    
    public function actionDownload($attr, $id){
        $attr = $this->clean($attr);
        $model = $this->findLectureCancel($id);
        $filename = 'Class Cancellation And Replacement ' . $id;
        
        
        
        UploadFile::download($model, $attr, $filename);
    }

    protected function findLectureCancel($id)
    {
        if (($model = LectureCancelFile::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    public function actionDelete($attr, $id)
    {
                    
        $attr = $this->clean($attr);
        $model = $this->findLectureCancel($id);

        $attr_db = $attr . '_file';
        
        $file = Yii::getAlias('@upload/' . $model->{$attr_db});

        if($model->delete()){
            if (is_file($file)) {
                unlink($file);
                
            }
            
            return Json::encode([
                        'good' => 2,
                    ]);
            
        }else{
            return Json::encode([
                        'errors' => $model->getErrors(),
                    ]);
        }
        


    }
    
    protected function clean($string){
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
    }

}