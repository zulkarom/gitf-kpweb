<?php

namespace backend\modules\courseFiles\controllers;

use Yii;
use yii\web\Controller;
use backend\modules\courseFiles\models\CoordinatorRubricsFile;
use backend\modules\teachingLoad\models\CourseOffered;
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
class CoordinatorRubricsFileController extends Controller
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
		$addFile = new AddFileForm;
		$files = $model->coordinatorRubricsFiles;
		
		
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
					$file = new CoordinatorRubricsFile;
					$file->scenario = 'add_rubrics';
					$file->offered_id = $id;
					$file->updated_at = new Expression('NOW()');
					if(!$file->save()){
						$file->flashError();
					}
				}				
			}
			Yii::$app->session->addFlash('success', 'File Slots Added');
			return $this->redirect(['page', 'id' => $id]);
        }
        
        return $this->render('/coordinator/class-rubrics-upload', [
            'model' => $model,
			'files' => $files,
			'addFile' => $addFile
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
        
        $model = new CoordinatorRubricsFile;
        $model->scenario = 'add_rubrics';
        
        $model->offered_id = $id;
        $model->updated_at = new Expression('NOW()');
        
        if(!$model->save()){
            $model->flashError();
        }
        
        return $this->redirect(['page', 'id' => $id]);
    }
    
    public function actionDeleteRow($id){
        $model = $this->findCoordinatorRubrics($id);
        
        $file = Yii::getAlias('@upload/' . $model->path_file);
            
        if($model->delete()){
			if (is_file($file)) {
                unlink($file);
                
            }
            return $this->redirect(['page', 'id' => $model->offered_id]);
        }
    }
    
    public function actionUploadFile($attr, $id){
        $attr = $this->clean($attr);
        $model = $this->findCoordinatorRubrics($id);
        $model->file_controller = 'coordinator-rubrics-file';
        $path = 'course-files/'.$model->offered->semester_id.'/'.$model->offered->course->course_code.'/'.$model->offered->id.'/4-class-continuous-assessment-rubrics';
        return UploadFile::upload($model, $attr, 'updated_at', $path);

    }
    
    public function actionDownloadFile($attr, $id){
        $attr = $this->clean($attr);
        $model = $this->findCoordinatorRubrics($id);
        $filename = 'Continuous Assessment Rubrics ' . $id;
        
        
        
        UploadFile::download($model, $attr, $filename);
    }

    protected function findCoordinatorRubrics($id)
    {
        if (($model = CoordinatorRubricsFile::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    public function actionDelete($attr, $id)
    {
                    
        $attr = $this->clean($attr);
        $model = $this->findCoordinatorRubrics($id);

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
