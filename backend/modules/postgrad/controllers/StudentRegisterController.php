<?php

namespace backend\modules\postgrad\controllers;

use Yii;
use backend\modules\postgrad\models\StudentRegister;
use backend\modules\postgrad\models\StudentRegisterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use backend\modules\postgrad\models\Student;
use common\models\Model;
use yii\helpers\ArrayHelper;

class StudentRegisterController extends Controller
{
    private function computeStatusAktifFromDaftar($statusDaftar)
    {
        $sd = $statusDaftar === null ? null : (int)$statusDaftar;
        if ($sd === StudentRegister::STATUS_DAFTAR_DAFTAR || $sd === StudentRegister::STATUS_DAFTAR_NOS) {
            return StudentRegister::STATUS_AKTIF_AKTIF;
        }
        return StudentRegister::STATUS_AKTIF_TIDAK_AKTIF;
    }

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

    public function actionModal($id)
    {
        $model = $this->findModel($id);

        return $this->renderAjax('_modal_detail', [
            'model' => $model,
        ]);
    }

    public function actionCreate($s)
    {
        $model = new StudentRegister();
        $student = $this->findStudent($s);

        if ($model->load(Yii::$app->request->post())) {
            $model->student_id = $s;
            $model->status_aktif = $this->computeStatusAktifFromDaftar($model->status_daftar);
            if($model->save()){
                return $this->redirect(['student/view', 'id' => $s]);
            }

            if ($model->hasErrors('student_id') || $model->hasErrors('semester_id')) {
                Yii::$app->session->addFlash('error', 'Duplicate registration: this student is already registered for the selected semester.');
            } else {
                Yii::$app->session->addFlash('error', 'Unable to save registration. Please check the form and try again.');
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

        if ($model->load(Yii::$app->request->post())) {
            $model->status_aktif = $this->computeStatusAktifFromDaftar($model->status_daftar);
            if ($model->save()) {
                Yii::$app->session->addFlash('success', 'Registration updated.');
                return $this->redirect(['student/view', 'id' => $model->student_id]);
            }

            Yii::$app->session->addFlash('error', 'Unable to save registration. Please check the form and try again.');
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionBulkEdit($s)
    {
        $student = $this->findStudent($s);
        $models = StudentRegister::find()
            ->where(['student_id' => (int)$s])
            ->orderBy(['semester_id' => SORT_ASC])
            ->all();

        if (empty($models)) {
            $m = new StudentRegister();
            $m->student_id = (int)$s;
            $models = [$m];
        }

        if (Yii::$app->request->isPost) {
            $oldIDs = ArrayHelper::map($models, 'id', 'id');
            $models = Model::createMultiple(StudentRegister::className(), $models);
            Model::loadMultiple($models, Yii::$app->request->post());

            foreach ($models as $m) {
                $m->student_id = (int)$s;
                $m->status_aktif = $this->computeStatusAktifFromDaftar($m->status_daftar);
            }

            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($models, 'id', 'id')));

            $valid = Model::validateMultiple($models);

            if ($valid) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    if (!empty($deletedIDs)) {
                        StudentRegister::deleteAll(['id' => $deletedIDs, 'student_id' => (int)$s]);
                    }

                    foreach ($models as $m) {
                        if (!$m->save(false)) {
                            $transaction->rollBack();
                            Yii::$app->session->addFlash('error', 'Unable to save bulk registration changes.');
                            return $this->render('bulk-edit', [
                                'student' => $student,
                                'models' => $models,
                            ]);
                        }
                    }

                    $transaction->commit();
                    Yii::$app->session->addFlash('success', 'Bulk registration updated.');
                    return $this->redirect(['student/view', 'id' => $s]);
                } catch (\Exception $e) {
                    $transaction->rollBack();
                    Yii::$app->session->addFlash('error', 'Unable to save bulk registration changes.');
                }
            }
        }

        return $this->render('bulk-edit', [
            'student' => $student,
            'models' => $models,
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
