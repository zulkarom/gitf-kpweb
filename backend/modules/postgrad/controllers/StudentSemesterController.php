<?php

namespace backend\modules\postgrad\controllers;

use Yii;
use backend\modules\postgrad\models\StudentSemester;
use backend\modules\postgrad\models\StudentSemesterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use backend\modules\postgrad\models\Student;

/**
 * StudentSemesterController implements the CRUD actions for StudentSemester model.
 */
class StudentSemesterController extends Controller
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
     * Lists all StudentSemester models.
     * @return mixed
     */
    public function actionIndex()
    {
    /*     $searchModel = new StudentSemesterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]); */
    }

    /**
     * Displays a single StudentSemester model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $modules = $model->modules;
        
        return $this->render('view', [
            'model' => $model,
            'modules' => $modules
        ]);
    }
    
    /**
     * Creates a new StudentSemester model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($s)
    {
        $model = new StudentSemester();
        $student = $this->findStudent($s);

        if ($model->load(Yii::$app->request->post())) {
            $model->student_id = $s;
            if($model->save()){
                return $this->redirect(['student/view', 'id' => $s]);
            }
            
        }

        return $this->render('create', [
            'model' => $model,
            'student' => $student,
        ]);
    }

    /**
     * Updates an existing StudentSemester model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['student/view', 'id' => $model->student_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing StudentSemester model.
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
            Yii::$app->session->addFlash('success', "Semester Deleted");
        } catch(\yii\db\IntegrityException $e) {
            
            Yii::$app->session->addFlash('error', "Cannot delete semester at this stage");
            
        }
        
        
        

        return $this->redirect(['student/view', 'id' => $student]);
    }

    /**
     * Finds the StudentSemester model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StudentSemester the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StudentSemester::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    
    protected function findStudent($id)
    {
        if (($model = Student::findOne($id)) !== null) {
            return $model;
        }
        
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
