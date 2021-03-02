<?php

namespace backend\modules\courseFiles\controllers;

use Yii;
use yii\web\Controller;
use backend\modules\courseFiles\models\LectureExemptFile;
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
class LectureExemptFileController extends Controller
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
        $files = $model->lectureExemptFiles;

        if ($model->load(Yii::$app->request->post())) {
            
            $model->updated_at = new Expression('NOW()');    
            
            Model::loadMultiple($files, Yii::$app->request->post());
            //print_r($files);die();
            
			if(Yii::$app->request->post('complete') == 1){
				$model->progressExemptClass = 1;
			}else{
				$model->progressExemptClass = 0;
			}
			if(Yii::$app->request->post('na') == 1){
				$model->na_class_exempt = 1;
				$model->progressExemptClass = 1;
			}else{
				$model->na_class_exempt = 0;
			}
			//echo $model->progressExemptClass ;die();
            
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
					if($progress and $model->prg_class_exempt == 0){
						$model->progressExemptClass = 0.5;
						$model->save();
					}
						
						
					}
					if($flag){
						$transaction->commit();
						Yii::$app->session->addFlash('success', "Data Updated");
						return $this->redirect(['default/teaching-assignment-lecture', 'id' => $model->id]);
					}else{
						Yii::$app->session->addFlash('error', "Make sure all files are uploaded");
						$transaction->rollBack();
					}
				} catch (Exception $e) {
                    $transaction->rollBack();
                    
                }

            }

        }

        if ($addFile->load(Yii::$app->request->post())) {
            $count = $addFile->file_number;
            if($count>0){
                for($i=1;$i<=$count;$i++){
                    $file = new LectureExemptFile;
                    $file->scenario = 'add_exempt';
                    $file->lecture_id = $id;
                    $file->updated_at = new Expression('NOW()');
                    if(!$file->save()){
                        $file->flashError();
                    }
                }               
            }
			$model->progressExemptClass = 0;
			$model->save();
            Yii::$app->session->addFlash('success', 'File Slots Added');
            return $this->redirect(['page', 'id' => $id]);
        }
		
        return $this->render('/lecture/class-exempt-upload', [
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
		
		$model = new LectureExemptFile;
		$model->scenario = 'add_exempt';
		
		$model->lecture_id = $id;
		$model->updated_at = new Expression('NOW()');
		
		if(!$model->save()){
			$model->flashError();
		}
		
		return $this->redirect(['page', 'id' => $id]);
	}
	
	public function actionDeleteRow($id){
		$model = $this->findLectureExempt($id);
		$file = Yii::getAlias('@upload/' . $model->path_file);
		$model->lecture->na_class_exempt = 0;
		$model->lecture->progressExemptClass= 0.5;
		$model->lecture->save();

		if($model->delete()){
			if (is_file($file)) {
                unlink($file);
                
            }
			return $this->redirect(['page', 'id' => $model->lecture_id]);
		}
	}
	
	public function actionUploadFile($attr, $id){
		$attr = $this->clean($attr);
        $model = $this->findLectureExempt($id);
		$model->file_controller = 'lecture-exempt-file';
		$path = 'course-files/'.$model->lecture->courseOffered->semester_id.'/'.$model->lecture->courseOffered->course->course_code.'/'.$model->lecture->lec_name.'/16-class-exemption';
		return UploadFile::upload($model, $attr, 'updated_at', $path);

	}
	
	public function actionDownloadFile($attr, $id){
		$attr = $this->clean($attr);
        $model = $this->findLectureExempt($id);
		$filename = 'Class Exemption ' . $id;
		
		
		
		UploadFile::download($model, $attr, $filename);
	}

    protected function findLectureExempt($id)
    {
        if (($model = LectureExemptFile::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	public function actionDelete($attr, $id)
	{
					
		$attr = $this->clean($attr);
        $model = $this->findLectureExempt($id);

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
