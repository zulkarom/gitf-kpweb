<?php

namespace backend\modules\moderasi\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use backend\models\SemesterForm;
use backend\models\Semester;
use backend\modules\teachingLoad\models\CourseOfferedSearch;
use backend\modules\teachingLoad\models\CourseOffered;
use backend\modules\moderasi\models\CourseChecker;
use backend\modules\staff\models\Staff;
use yii\helpers\ArrayHelper;

class DefaultController extends Controller
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
        $semester = new SemesterForm;
        $session = Yii::$app->session;

        if (Yii::$app->getRequest()->getQueryParam('SemesterForm')) {
            $sem = Yii::$app->getRequest()->getQueryParam('SemesterForm');
            $semester->semester_id = $sem['semester_id'];
            $semester->str_search = $sem['str_search'];
            $semester->program_search = $sem['program_search'];
            $session->set('semester', $sem['semester_id']);
        } elseif ($session->has('semester')) {
            $semester->semester_id = $session->get('semester');
        } else {
            $current = Semester::getCurrentSemester();
            $semester->semester_id = $current ? $current->id : null;
        }

        $searchModel = new CourseOfferedSearch();
        $searchModel->semester = $semester->semester_id;
        $searchModel->search_course = $semester->str_search;
        $searchModel->search_program = $semester->program_search;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'semester' => $semester,
        ]);
    }

    public function actionAssign($id)
    {
        $offered = CourseOffered::findOne((int)$id);
        if ($offered === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $model = CourseChecker::findByOfferedId($offered->id);
        if ($model === null) {
            $model = new CourseChecker();
            $model->offered_id = $offered->id;
        }

        if ($model->load(Yii::$app->request->post())) {
            $model->touchUpdated();
            if ($model->save()) {
                Yii::$app->session->addFlash('success', 'Checker/Vetter assignment saved.');
                return $this->redirect(['index']);
            }
        }

        $staffList = ArrayHelper::map(Staff::getAcademicStaff(), 'id', function ($staff) {
            return $staff->user ? ($staff->user->fullname . ' (' . $staff->staff_title . ')') : $staff->staff_title;
        });

        return $this->render('assign', [
            'model' => $model,
            'offered' => $offered,
            'staffList' => $staffList,
        ]);
    }
}
