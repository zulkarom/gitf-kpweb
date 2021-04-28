<?php

namespace frontend\modules\conference\controllers;

use Yii;
use backend\modules\conference\models\ConfDownload;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use backend\modules\conference\models\UploadConfFile as UploadFile;

/**
 * ConferenceController implements the CRUD actions for Conference model.
 */
class DownloadController extends Controller
{

	public function actionDownloadFile($id){
        $model = $this->findModel($id);
        $filename = $model->download_name;
        UploadFile::download($model, 'download', $filename);
    }
	
	/**
     * Finds the Conference model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Conference the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ConfDownload::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
