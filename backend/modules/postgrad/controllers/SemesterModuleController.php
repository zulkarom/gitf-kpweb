<?php

namespace backend\modules\postgrad\controllers;

use Yii;
use backend\modules\postgrad\models\SemesterModule;
use backend\modules\postgrad\models\StudentSemester;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;

/**
 * SemesterModuleController implements the CRUD actions for SemesterModule model.
 */
class SemesterModuleController extends Controller
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

    /**
     * Lists all SemesterModule models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => SemesterModule::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SemesterModule model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new SemesterModule model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($semester)
    {
        $model = new SemesterModule();
        $studentSemester = $this->findStudentSemester($semester);

        if ($model->load(Yii::$app->request->post())) {
            $model->student_sem_id = $studentSemester->id;
            if($model->save()){
                return $this->redirect(['student-semester/view', 'id' => $semester]);
            }
            
        }

        return $this->render('create', [
            'model' => $model,
            'studentSemester' => $studentSemester
        ]);
    }

    /**
     * Updates an existing SemesterModule model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['student-semester/view', 'id' => $model->student_sem_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing SemesterModule model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        try {
            $model = $this->findModel($id);
            $sem = $model->student_sem_id;
            $model->delete();
            Yii::$app->session->addFlash('success', "Module Deleted");
        } catch(\yii\db\IntegrityException $e) {
            
            Yii::$app->session->addFlash('error', "Cannot delete module at this stage");
            
        }
        

        return $this->redirect(['student-semester/view', 'id' => $sem]);
        
    }

    /**
     * Finds the SemesterModule model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SemesterModule the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SemesterModule::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function findStudentSemester($id)
    {
        if (($model = StudentSemester::findOne($id)) !== null) {
            return $model;
        }
        
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
