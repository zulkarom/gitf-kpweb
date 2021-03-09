<?php

namespace backend\modules\courseFiles\controllers;

use Yii;
use yii\web\Controller;
use backend\modules\courseFiles\models\CoordinatorSummativeAssessmentFile;
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
class CoordinatorSummativeAssessmentFileController extends Controller
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
		$files = $model->coordinatorSummativeAssessmentFiles;
		
		
		if ($model->load(Yii::$app->request->post())) {
			
			$model->updated_at = new Expression('NOW()');    
			
			Model::loadMultiple($files, Yii::$app->request->post());
			//print_r($files);die();
			
			if(Yii::$app->request->post('complete') == 1){
				$model->progressSumAssess = 1;
			}else{
				$model->progressSumAssess = 0;
			}
			if(Yii::$app->request->post('na') == 1){
				$model->na_sum_assess = 1;
				$model->progressSumAssess = 1;
			}else{
				$model->na_sum_assess = 0;
			}
			//echo $model->progressSumAssess ;die();
            
            $valid = $model->validate();
            $valid = Model::validateMultiple($files) && $valid;
			
            
            if($valid){
				$transaction = Yii::$app->db->beginTransaction();
				try {
					if($flag = $model->save()){
						$progress = false;
						foreach ($files as $item) {
							if ($flag === false) {
									break;
								}
							if($item->path_file){
								if($item->save()){
									$progress = true;
								}else{
									$item->flashError();
									$flag = false;
									break;
									
								}
							}else{
								$flag = false;
							}
							
						}
					if($progress and $model->prg_sum_assess == 0){
						$model->progressSumAssess = 0.5;
						$model->save();
					}
						
						
					}
					if($flag){
						$transaction->commit();
						Yii::$app->session->addFlash('success', "Data Updated");
						return $this->redirect(['default/teaching-assignment-coordinator', 'id' => $model->id]);
					}else{
						Yii::$app->session->addFlash('error', "Make sure all files are uploaded");
						$transaction->rollBack();
					}
				} catch (Exception $e) {
                    $transaction->rollBack();
					//die();
                    
                }

            }

        }

        if ($addFile->load(Yii::$app->request->post())) {
            $count = $addFile->file_number;
            if($count>0){
                for($i=1;$i<=$count;$i++){
                    $file = new CoordinatorSummativeAssessmentFile;
                    $file->scenario = 'add_summative_assessment';
                    $file->offered_id = $id;
                    $file->updated_at = new Expression('NOW()');
                    if(!$file->save()){
                        $file->flashError();
                    }
                }               
            }
			$model->progressSumAssess = 0;
			$model->na_sum_assess = 0;
			$model->save();
            Yii::$app->session->addFlash('success', 'File Slots Added');
            return $this->redirect(['page', 'id' => $id]);
        }
        
        return $this->render('/coordinator/class-summative-assessment-upload', [
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
        
        $model = new CoordinatorSummativeAssessmentFile;
        $model->scenario = 'add_summative_assessment';
        
        $model->offered_id = $id;
        $model->updated_at = new Expression('NOW()');
        
        if(!$model->save()){
            $model->flashError();
        }
        
        return $this->redirect(['page', 'id' => $id]);
    }
    
    public function actionDeleteRow($id){
        $model = $this->findCoordinatorSummativeAssessment($id);
        $file = Yii::getAlias('@upload/' . $model->path_file);
		$model->offered->na_sum_assess = 0;
		$model->offered->progressSumAssess = 0.5;
		$model->offered->save();
            
        if($model->delete()){
			if (is_file($file)) {
                unlink($file);
                
            }
            return $this->redirect(['page', 'id' => $model->offered_id]);
        }
    }
    
    public function actionUploadFile($attr, $id){
        $attr = $this->clean($attr);
        $model = $this->findCoordinatorSummativeAssessment($id);
        $model->file_controller = 'coordinator-summative-assessment-file';
        $path = 'course-files/'.$model->offered->semester_id.'/'.$model->offered->course->course_code.'/'.$model->offered->id.'/14-class-summative-assessment';
        return UploadFile::upload($model, $attr, 'updated_at', $path);

    }
    
    public function actionDownloadFile($attr, $id){
        $attr = $this->clean($attr);
        $model = $this->findCoordinatorSummativeAssessment($id);
        $filename = 'Summative Assessment ' . $id;
        
        
        
        UploadFile::download($model, $attr, $filename);
    }

    protected function findCoordinatorSummativeAssessment($id)
    {
        if (($model = CoordinatorSummativeAssessmentFile::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    public function actionDelete($attr, $id)
    {
                    
        $attr = $this->clean($attr);
        $model = $this->findCoordinatorSummativeAssessment($id);

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
