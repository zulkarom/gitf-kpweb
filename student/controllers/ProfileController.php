<?php

namespace student\controllers;

use Yii;
use backend\modules\postgrad\models\Student;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use common\models\User;
/**
 * ProfileController implements the CRUD actions for Entrepreneur model.
 */
class ProfileController extends Controller
{
    /**
     * {@inheritdoc}
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
     * Lists all Entrepreneur models.
     * @return mixed
     */
    public function actionIndex()
    {
        $id = Yii::$app->user->identity->studentPostGrad->id;
        
        $model = $this->findModel($id);
        $modelUser = User::findOne($model->user_id);

        $model->setScenario('student_update');


        if ($model->load(Yii::$app->request->post())) {

                if($model->save()){
                   Yii::$app->session->addFlash('success', "Information Saved");

                    return $this->refresh();
                }else{
                    $model->flashError();

                }
            }

        return $this->render('index', [
            'model' => $model,
            'modelUser' => $modelUser,
        ]);

    }
   
    /**
     * Finds the Entrepreneur model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Entrepreneur the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Student::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
