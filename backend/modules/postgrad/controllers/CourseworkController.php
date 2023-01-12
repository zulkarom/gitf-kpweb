<?php

namespace backend\modules\postgrad\controllers;

use backend\models\Semester;
use backend\models\SemesterForm;
use backend\modules\courseFiles\models\DateSetting;
use backend\modules\postgrad\models\CourseworkSearch;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Default controller for the `postgrad` module
 */
class CourseworkController extends Controller
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
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
		$semester = new SemesterForm();
		$session = Yii::$app->session;
        if(Yii::$app->getRequest()->getQueryParam('SemesterForm')){
            $sem = Yii::$app->getRequest()->getQueryParam('SemesterForm');
            $semester->semester_id = $sem['semester_id'];
            $semester->program_id = $sem['program_id'];
			$session->set('semester', $sem['semester_id']);
        }else if($session->has('semester')){
			$semester->semester_id = $session->get('semester');
		}else{
            $semester->semester_id = Semester::getCurrentSemester()->id;
        }
	

        $searchModel = new CourseworkSearch();
        $searchModel->semester = $semester->semester_id;
        $searchModel->program_id = $semester->program_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'semester' => $semester
        ]);
    }

    public function actionPullStudentFromCourseFile($semester){
        //senarai course offer program 81,82
        //setiap course tgk student dlm lecture
        //setiap student tu tarik masuk pg
    }

    
    
    
}
