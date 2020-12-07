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
		
        return $this->render('/lecture-test/class-exempt-upload', [
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
		if($model->delete()){
			return $this->redirect(['page', 'id' => $model->lecture_id]);
		}
	}
	
	public function actionUploadFile($attr, $id){
		$attr = $this->clean($attr);
        $model = $this->findLectureExempt($id);
		$model->file_controller = 'lecture-exempt-file';
		
		return UploadFile::upload($model, $attr, 'updated_at');

	}
	
	public function actionDownload($attr, $id){
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