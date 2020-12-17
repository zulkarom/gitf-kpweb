<?php

namespace backend\modules\teachingLoad\controllers;


use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\db\Expression;
use yii\filters\AccessControl;
use backend\modules\teachingLoad\models\AppointmentLetter;
use backend\modules\teachingLoad\models\AppointmentLetterFile;

class AppointmentLetterController extends Controller
{
	    
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

    public function actionPdf($id){
        $model = $this->findModel($id);
        $pdf = new AppointmentLetterFile;
        $pdf->model = $model;
        $pdf->generatePdf();
    }

    protected function findModel($id)
    {
        if (($model = AppointmentLetter::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}