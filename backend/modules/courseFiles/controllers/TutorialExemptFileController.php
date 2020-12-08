<?php

namespace backend\modules\courseFiles\controllers;

use Yii;
use yii\web\Controller;
use backend\modules\courseFiles\models\TutorialExemptFile;
use backend\modules\teachingLoad\models\TutorialLecture;
use yii\filters\AccessControl;
use yii\db\Expression;
use yii\web\NotFoundHttpException;
use common\models\UploadFile;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * Default controller for the `course-files` module
 */
class TutorialExemptFileController extends Controller
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
        $model = $this->findTutorial($id);
        
        return $this->render('/tutorial-test/class-exempt-upload', [
            'model' => $model,
        ]);
    }
    
    protected function findTutorial($id)
    {
        if (($model = TutorialLecture::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionAdd($id){
        
        $model = new TutorialExemptFile;
        $model->scenario = 'add_exempt';
        
        $model->tutorial_id = $id;
        $model->updated_at = new Expression('NOW()');
        
        if(!$model->save()){
            $model->flashError();
        }
        
        return $this->redirect(['page', 'id' => $id]);
    }
    
    public function actionDeleteRow($id){
        $model = $this->findTutorialExempt($id);
        if($model->delete()){
            return $this->redirect(['page', 'id' => $model->tutorial_id]);
        }
    }
    
    public function actionUploadFile($attr, $id){
        $attr = $this->clean($attr);
        $model = $this->findTutorialExempt($id);
        $model->file_controller = 'tutorial-exempt-file';
        $path = 'course-files/'.$model->tutorial->lecture->courseOffered->semester_id.'/'.$model->tutorial->lecture->courseOffered->course->course_code.'/'.$model->tutorial->tutorial_name.'/16-class-cancellation';
        return UploadFile::upload($model, $attr, 'updated_at', $path);

    }
    
    public function actionDownload($attr, $id){
        $attr = $this->clean($attr);
        $model = $this->findTutorialExempt($id);
        $filename = 'Class Exemption ' . $id;
        
        
        
        UploadFile::download($model, $attr, $filename);
    }

    protected function findTutorialExempt($id)
    {
        if (($model = TutorialExemptFile::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    public function actionDelete($attr, $id)
    {
                    
        $attr = $this->clean($attr);
        $model = $this->findTutorialExempt($id);

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