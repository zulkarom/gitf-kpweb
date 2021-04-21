<?php

namespace frontend\controllers;

use Yii;
use backend\modules\downloads\models\Download;
use frontend\models\DownloadFormExternal;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\downloads\models\UploadFile;


/**
 * ProceedingController implements the CRUD actions for Proceeding model.
 */
class DownloadController extends Controller
{

	public function actionExternal()
    {
		$model = new DownloadFormExternal;
		if ($model->load(Yii::$app->request->post())) {
			
			$student = $this->findDownload($model->category, $model->nric);
			if($student){
				if(!UploadFile::downloadCategory($student)){
					Yii::$app->session->addFlash('error', "File not found!");
					//return $this->refresh();
				}
			}else{
				Yii::$app->session->addFlash('error', "No document found for this NRIC under the selected category!");
				//return $this->refresh();
			}
		}

        return $this->render('external', [
			'model' => $model
        ]);
    }
	
	
	protected function findDownload($category, $nric)
    {
        $model = Download::find()
		->where(['category_id' => $category, 'nric' => $nric])
		->one();
		
		if($model !== null){
			return $model;
		}

        return false;
    }
	

}
