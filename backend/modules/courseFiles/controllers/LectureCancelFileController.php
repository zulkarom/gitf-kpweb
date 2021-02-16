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

use backend\modules\courseFiles\models\AddFileForm;
use common\models\Model;

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
        $addFile = new AddFileForm;
        $files = $model->lectureCancelFiles;

        if ($model->load(Yii::$app->request->post())) {
			
            
            $model->updated_at = new Expression('NOW()');    
            
            Model::loadMultiple($files, Yii::$app->request->post());
            //print_r($files);die();
            
            $valid = $model->validate();
            $valid = Model::validateMultiple($files) && $valid;
            
            if($valid){
                if($model->save()){
                    $flag = true;
                    foreach ($files as $item) {
                        //Yii::$app->session->addFlash('success', $item->file_name);
                        if(!$item->save()){
                            $item->flashError();
                            $flag = false;
                            break;
                            
                        }
                    }
                    if($flag){
                        Yii::$app->session->addFlash('success', "Data Updated");
                        return $this->redirect(['page', 'id' => $model->id]);
                    }
                    
                }
            }

        }

        if ($addFile->load(Yii::$app->request->post())) {
            $count = $addFile->file_number;
            if($count>0){
                for($i=1;$i<=$count;$i++){
                    $file = new LectureCancelFile;
                    $file->scenario = 'add_cancel';
                    $file->lecture_id = $id;
                    $file->updated_at = new Expression('NOW()');
                    if(!$file->save()){
                        $file->flashError();
                    }
                }               
            }
            Yii::$app->session->addFlash('success', 'File Slots Added');
            return $this->redirect(['page', 'id' => $id]);
        }

        
        return $this->render('/lecture/class-cancel-upload', [
            'model' => $model,
            'files' => $files,
            'addFile' => $addFile
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
        $file = Yii::getAlias('@upload/' . $model->path_file);

        if($model->delete()){
            if (is_file($file)) {
                unlink($file);
                
            }
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
    
    public function actionDownloadFile($attr, $id){
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
