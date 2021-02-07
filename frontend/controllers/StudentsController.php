<?php

namespace frontend\controllers;

use Yii;
use backend\modules\students\models\InternshipList;
use frontend\models\InternshipForm;
use backend\modules\students\models\DeanList;
use backend\modules\students\models\Download;
use frontend\models\DeanListForm;
use frontend\models\DownloadForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\students\models\UploadFile;


/**
 * ProceedingController implements the CRUD actions for Proceeding model.
 */
class StudentsController extends Controller
{

    public function actionInternship()
    {
		$model = new InternshipForm;
		if ($model->load(Yii::$app->request->post())) {
			$attr = 'paper';
			$student = $this->findInternship($model->matric, $model->nric);
			if($student){
				if(!UploadFile::download($student, $attr, $student->nric)){
					Yii::$app->session->addFlash('error', "File not exist!");
					//return $this->refresh();
				}
			}else{
				Yii::$app->session->addFlash('error', "Student record not exist!");
				//return $this->refresh();
			}
		}

        return $this->render('internship', [
			'model' => $model
        ]);
    }
	
	public function actionDeanlist()
    {
		$model = new DeanListForm;
		if ($model->load(Yii::$app->request->post())) {
			$attr = 'paper';
			$student = $this->findDeanList($model->semester, $model->matric, $model->nric);
			if($student){
				if(!UploadFile::download($student, $attr, $student->matric_no, $student->semester_id)){
					Yii::$app->session->addFlash('error', "File not exist!");
					//return $this->refresh();
				}
			}else{
				Yii::$app->session->addFlash('error', "Student record not exist!");
				//return $this->refresh();
			}
		}

        return $this->render('dean-list', [
			'model' => $model
        ]);
    }
	
	public function actionDownloads()
    {
		$model = new DownloadForm;
		if ($model->load(Yii::$app->request->post())) {
			
			$student = $this->findDownload($model->category, $model->matric, $model->nric);
			if($student){
				if(!UploadFile::downloadCategory($student)){
					Yii::$app->session->addFlash('error', "File not found!");
					//return $this->refresh();
				}
			}else{
				Yii::$app->session->addFlash('error', "No document found for this student under the selected category!");
				//return $this->refresh();
			}
		}

        return $this->render('downloads', [
			'model' => $model
        ]);
    }
	

    protected function findInternship($matric, $nric)
    {
        if (($model = InternshipList::findOne(['matrik' => $matric, 'nric' => $nric])) !== null) {
            return $model;
        }

        return false;
    }
	
	protected function findDeanList($semester, $matric, $nric)
    {
        $model = DeanList::find()
		->joinWith(['student'])
		->where(['st_dean_list.semester_id' => $semester, 'st_student.matric_no' => $matric, 'st_student.nric' => $nric])
		->one();
		
		if($model !== null){
			return $model;
		}

        return false;
    }
	
	protected function findDownload($category, $matric, $nric)
    {
        $model = Download::find()
		->joinWith(['student'])
		->where(['category_id' => $category, 'st_student.matric_no' => $matric, 'st_student.nric' => $nric])
		->one();
		
		if($model !== null){
			return $model;
		}

        return false;
    }
	

}
