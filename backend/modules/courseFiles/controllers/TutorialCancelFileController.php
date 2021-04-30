<?php

namespace backend\modules\courseFiles\controllers;

use Yii;
use yii\web\Controller;
use backend\modules\courseFiles\models\TutorialCancelFile;
use backend\modules\teachingLoad\models\TutorialLecture;
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
class TutorialCancelFileController extends Controller
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
        $addFile = new AddFileForm;
        $files = $model->tutorialCancelFiles;

        if ($model->load(Yii::$app->request->post())) {
            
            $model->updated_at = new Expression('NOW()');    
            
            Model::loadMultiple($files, Yii::$app->request->post());
            //print_r($files);die();
            
			
			if(Yii::$app->request->post('complete') == 1){
				$model->progressCancelClass = 1;
			}else{
				$model->progressCancelClass = 0;
			}
			if(Yii::$app->request->post('na') == 1){
				$model->na_class_cancel = 1;
				$model->progressCancelClass = 1;
			}else{
				$model->na_class_cancel = 0;
			}
			

            
            $valid = $model->validate();
            $valid = Model::validateMultiple($files) && $valid;
			
            
            if($valid){
				
				$transaction = Yii::$app->db->beginTransaction();
				try {
					if($flag = $model->save()){
						//echo $model->prg_overall;
						//die();
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
					if($progress and $model->prg_class_cancel == 0){
						$model->progressCancelClass = 0.5;
						$model->save();
					}
						
						
					}
					if($flag){
						$transaction->commit();
						Yii::$app->session->addFlash('success', "Data Updated");
						return $this->redirect(['default/teaching-assignment-tutorial', 'id' => $model->id]);
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
                    $file = new TutorialCancelFile;
                    $file->scenario = 'add_cancel';
                    $file->tutorial_id = $id;
                    $file->updated_at = new Expression('NOW()');
                    if(!$file->save()){
                        $file->flashError();
                    }
                }               
            }
			$model->progressCancelClass = 0;
			$model->na_class_cancel = 0;
			$model->save();
            Yii::$app->session->addFlash('success', 'File Slots Added');
            return $this->redirect(['page', 'id' => $id]);
        }
        
        return $this->render('/tutorial/class-cancel-upload', [
            'model' => $model,
            'files' => $files,
            'addFile' => $addFile
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
        
        $model = new TutorialCancelFile;
        $model->scenario = 'add_cancel';
        
        $model->tutorial_id = $id;
        $model->updated_at = new Expression('NOW()');
        
        if(!$model->save()){
            $model->flashError();
        }
        
        return $this->redirect(['page', 'id' => $id]);
    }
    
    public function actionDeleteRow($id){
        $model = $this->findTutorialCancel($id);
        $file = Yii::getAlias('@upload/' . $model->path_file);
		$model->tutorial->na_class_cancel = 0;
		$model->tutorial->progressCancelClass = 0.5;
		$model->tutorial->save();
        if($model->delete()){
            if (is_file($file)) {
                unlink($file);
                
            }
            return $this->redirect(['page', 'id' => $model->tutorial_id]);
        }
    }
    
    public function actionUploadFile($attr, $id){
        $attr = $this->clean($attr);
        $model = $this->findTutorialCancel($id);
        $model->file_controller = 'tutorial-cancel-file';
        $path = 'course-files/'.$model->tutorial->lecture->courseOffered->semester_id.'/'.$model->tutorial->lecture->courseOffered->course->course_code.'/'.$model->tutorial->tutorial_name.'/10-class-cancellation';
        return UploadFile::upload($model, $attr, 'updated_at', $path);

    }
    
    public function actionDownloadFile($attr, $id){
        $attr = $this->clean($attr);
        $model = $this->findTutorialCancel($id);
        $filename = 'Class Cancellation And Replacement ' . $id;
        
        
        
        UploadFile::download($model, $attr, $filename);
    }

    protected function findTutorialCancel($id)
    {
        if (($model = TutorialCancelFile::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    public function actionDelete($attr, $id)
    {
                    
        $attr = $this->clean($attr);
        $model = $this->findTutorialCancel($id);

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
