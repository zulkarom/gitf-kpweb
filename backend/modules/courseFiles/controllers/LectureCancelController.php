<?php

namespace backend\modules\courseFiles\controllers;

use Yii;
use yii\web\Controller;
use backend\modules\courseFiles\models\LectureCancel;
/**
 * Default controller for the `course-files` module
 */
class LectureCancelController extends Controller
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


    public function actionAdd(){
		$model = new LectureCancel;
		$model->scenario = 'add_cert';
		
		$model->fasi_id = Fasi::findOne(['user_id' => Yii::$app->user->identity->id])->id;
		$model->updated_at = new Expression('NOW()');
		
		if(!$model->save()){
			Yii::$app->session->addFlash('error', "Add Cert failed!");
		}
		return $this->redirect(['document/index']);
	}

    protected function findCert($id)
    {
        if (($model = LectureCancel::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

