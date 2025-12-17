<?php

namespace backend\modules\postgrad\controllers;

use Yii;
use backend\modules\postgrad\models\StudentRegister;
use backend\modules\postgrad\models\StudentRegisterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use backend\modules\postgrad\models\Student;

class StudentRegisterController extends Controller
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

    public function actionIndex()
    {
        /*     $searchModel = new StudentRegisterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]); */
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        $modules = $model->modules;

        return $this->render('view', [
            'model' => $model,
            'modules' => $modules
        ]);
    }

    public function actionCreate($s)
    {
        $model = new StudentRegister();
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

    protected function findModel($id)
    {
        if (($model = StudentRegister::findOne($id)) !== null) {
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
