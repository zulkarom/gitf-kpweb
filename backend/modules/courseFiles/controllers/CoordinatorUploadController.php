<?php

namespace backend\modules\courseFiles\controllers;

use Yii;
use yii\web\Controller;
use backend\modules\courseFiles\models\CoordinatorAnswerScriptFile;
use backend\modules\teachingLoad\models\CourseOffered;
use yii\filters\AccessControl;
use yii\db\Expression;
use yii\web\NotFoundHttpException;
use common\models\UploadFile;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * Default controller for the `course-files` module
 */
class CoordinatorUploadController extends Controller
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
        $model = $this->findOffered($id);
        
        return $this->render('/coordinator/class-answer-script-upload', [
            'model' => $model,
        ]);
    }
    
    protected function findOffered($id)
    {
        if (($model = CourseOffered::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionAdd($id){
        
        $model = new CoordinatorAnswerScriptFile;
        $model->scenario = 'add_answer_script';
        
        $model->offered_id = $id;
        $model->updated_at = new Expression('NOW()');
        
        if(!$model->save()){
            $model->flashError();
        }
        
        return $this->redirect(['page', 'id' => $id]);
    }
    
    public function actionDeleteRow($id){
        $model = $this->findCoordinatorAnswerScript($id);
        if($model->delete()){
            return $this->redirect(['page', 'id' => $model->offered_id]);
        }
    }
    
    public function actionUploadFile($attr, $id){
        $attr = $this->clean($attr);
        $model = $this->findOffered($id);
        $model->file_controller = 'coordinator-upload';
        $path = 'course-files/'.$model->semester_id.'/'.$model->course->course_code.'/'.$model->id.'/15-class-student-final-exam-answer-script';
        return UploadFile::upload($model, $attr, 'updated_at', $path);

    }
    
    public function actionDownloadFile($attr, $id){
        $attr = $this->clean($attr);
        $model = $this->findOffered($id);
        $filename = $attr;
        
        
        
        UploadFile::download($model, $attr, $filename);
    }

    protected function findCoordinatorAnswerScript($id)
    {
        if (($model = CoordinatorAnswerScriptFile::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    public function actionDeleteFile($attr, $id)
    {
                    
        $attr = $this->clean($attr);
        $model = $this->findOffered($id);

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
    
    protected function clean($string){
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
    }

}
