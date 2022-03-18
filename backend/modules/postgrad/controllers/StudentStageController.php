<?php

namespace backend\modules\postgrad\controllers;

use Yii;
use backend\modules\postgrad\models\Student;
use backend\modules\postgrad\models\StudentStage;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;

/**
 * StudentStageController implements the CRUD actions for StudentStage model.
 */
class StudentStageController extends Controller
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
     * Lists all StudentStage models.
     * @return mixed
     */
    public function actionIndex()
    {
       return $this->redirect(['student/index']);
    }

    /**
     * Displays a single StudentStage model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        
        $examiners = $model->examiners;
        
        return $this->render('view', [
            'model' => $model,
            'examiners' => $examiners
        ]);
    }

    /**
     * Creates a new StudentStage model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($s)
    {
        $model = new StudentStage();
        $student = $this->findStudent($s);
        
        if ($model->load(Yii::$app->request->post())) {
            $model->student_id = $s;
            if($model->save()){
                return $this->redirect(['student/view', 'id' => $s]);
            }
            
        }
        
        return $this->render('create', [
            'model' => $model,
            'student' => $student
        ]);
    }
    
    protected function findStudent($id)
    {
        if (($model = Student::findOne($id)) !== null) {
            return $model;
        }
        
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Updates an existing StudentStage model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                return $this->redirect(['view', 'id' => $id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing StudentStage model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        try {
            $model = $this->findModel($id);
            $student = $model->student_id;
            $model->delete();
            Yii::$app->session->addFlash('success', "Stage Deleted");
        } catch(\yii\db\IntegrityException $e) {
            
            Yii::$app->session->addFlash('error', "Cannot delete the research stage. Delete all related data first e.g. examiners");
            
        }
        
        
        
        
        return $this->redirect(['student/view', 'id' => $student]);
        
    }

    /**
     * Finds the StudentStage model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StudentStage the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StudentStage::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
