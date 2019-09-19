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
use backend\modules\staff\models\StaffEducation;
use yii\data\ActiveDataProvider;

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
	
	public function actionEducation(){

       $dataProvider = new ActiveDataProvider([
           'query' => StaffEducation::find()
		   ->where(['edu_staff' => Yii::$app->user->identity->staff->id,]
		)->orderBy('edu_level DESC'),
       ]);
	   
       return $this->render('education', [
           'dataProvider' => $dataProvider,
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
	
	/**
     * Creates a new StaffEducation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAddEdu()
    {
        $model = new StaffEducation();

        if ($model->load(Yii::$app->request->post())) {
			$model->edu_staff = Yii::$app->user->identity->staff->id;
			if($model->save()){
				return $this->redirect(['education']);
			}
			
            
        }

        return $this->render('add_edu', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing StaffEducation model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateEdu($id)
    {
        $model = $this->findEducation($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			Yii::$app->session->addFlash('success', "Data Updated");
            return $this->redirect(['education']);
        }

        return $this->render('update_edu', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing StaffEducation model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDeleteEdu($id)
    {
        $this->findEducation($id)->delete();

        return $this->redirect(['education']);
    }

    /**
     * Finds the StaffEducation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StaffEducation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findEducation($id)
    {
        if (($model = StaffEducation::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	

}
