<?php

namespace backend\modules\staff\controllers;

use Yii;
use backend\modules\staff\models\Staff;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\models\User;
use common\models\Upload;
use common\models\UploadFile;
use yii\helpers\Json;
use yii\db\Expression;
use yii\filters\AccessControl;

/**
 * StaffController implements the CRUD actions for Staff model.
 */
class ProfileController extends Controller
{
    /**
     * @inheritdoc
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


    /**
     * Lists all Staff models.
     * @return mixed
     */
    public function actionIndex()
    {
		$model = $this->findModel();

        if ($model->load(Yii::$app->request->post())) {
			
			if($model->save()){
				Yii::$app->session->addFlash('success', "Data Updated");
				return $this->redirect(['index']);
			}
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Staff model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Staff the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel()
    {
        if (($model = Staff::findOne(Yii::$app->user->identity->staff->id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	
	

}
