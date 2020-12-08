<?php

namespace frontend\controllers;

use Yii;
use backend\modules\internship\models\InternshipList;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\internship\models\UploadFile;
use frontend\models\InternshipForm;

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
			$model = $this->findModel($model->matric, $model->nric);
			if(!$model){
				Yii::$app->session->addFlash('error', "Student record not exist!");
				return $this->refresh();
			}

				if(!UploadFile::download($model, $attr, $model->nric)){
					Yii::$app->session->addFlash('error', "File not exist!");
					return $this->refresh();
				}
			}

        return $this->render('internship', [
			'model' => $model
        ]);
    }
	
	public function actionDownloadFile($id){
        
    }

    protected function findModel($matric, $nric)
    {
        if (($model = InternshipList::findOne(['matrik' => $matric, 'nric' => $nric])) !== null) {
            return $model;
        }

        return false;
    }
	

}
