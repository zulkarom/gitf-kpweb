<?php

namespace backend\modules\courseFiles\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\db\Expression;
use yii\web\NotFoundHttpException;
use backend\modules\teachingLoad\models\CourseOffered;

/**
 * Default controller for the `course-files` module
 */
class CoordinatorController extends Controller
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
    
    public function actionCourseCqi($id)
    {
        $model = $this->findOffered($id);
		
		if ($model->load(Yii::$app->request->post())) {
			
			if($model->save()){
				Yii::$app->session->addFlash('success', "Data Updated");
				return $this->redirect(['default/teaching-assignment-coordinator', 'id' => $id]);
			}

		}

        return $this->render('course-cqi', [
            'model' => $model,
        ]);
    }
	
	protected function findOffered($id)
    {
        if (($model = CourseOffered::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
