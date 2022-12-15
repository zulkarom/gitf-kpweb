<?php

namespace backend\modules\courseFiles\controllers;

use Yii;
use yii\web\Controller;
use backend\modules\courseFiles\models\ProgramCoordinatorSearch;
use backend\modules\courseFiles\models\HeadDepartmentSearch;
use backend\modules\teachingLoad\models\CourseOffered;
use backend\modules\courseFiles\models\Checklist;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use backend\models\Department;
use backend\models\SemesterForm;
use backend\models\Semester;
use backend\modules\courseFiles\models\ProgramCoordinatorUmumSearch;
use backend\modules\esiap\models\Program;

/**
 * Default controller for the `course-files` module
 */
class ProgramController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
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
	

    public function actionProgramCoordinator()
    {
        //check dia coordinator ke tak
        $program = Program::findOne(['head_program' => Yii::$app->user->identity->staff->id]);
        $semester = new SemesterForm;
        $session = Yii::$app->session;
        if(Yii::$app->getRequest()->getQueryParam('SemesterForm')){
            $sem = Yii::$app->getRequest()->getQueryParam('SemesterForm');
            $semester->semester_id = $sem['semester_id'];
            $semester->str_search = $sem['str_search'];
            $session->set('semester', $sem['semester_id']);
        }else if($session->has('semester')){
            $semester->semester_id = $session->get('semester');
        }else{
            $semester->semester_id = Semester::getCurrentSemester()->id;
        }
        
        $searchModel = new ProgramCoordinatorSearch();
        $searchModel->semester = $semester->semester_id;
        $searchModel->program = $program;
        $searchModel->search_course = $semester->str_search;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProviderUmum = null;
        $searchModelUmum = null;
        $programUmum = null;

        if($program){
            if($program->id != 80){
                $programUmum = Program::findOne(80);
                $searchModelUmum = new ProgramCoordinatorUmumSearch();
                $searchModelUmum->semester = $semester->semester_id;
                $searchModelUmum->program = $program;
                $searchModelUmum->search_course = $semester->str_search;
                $dataProviderUmum  = $searchModelUmum->search(Yii::$app->request->queryParams);
            }
            
        }
        
        
        
        return $this->render('program-coordinator', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchModelUmum' => $searchModelUmum,
            'dataProviderUmum' => $dataProviderUmum,
            'semester' => $semester,
            'program' => $program,
            'programUmum' => $programUmum
        ]);
    }
	
    public function actionHeadDepartment()
    {
        //check dia coordinator ke tak
        $department = Department::findOne(['head_dep' => Yii::$app->user->identity->staff->id]);
        $semester = new SemesterForm;
        $session = Yii::$app->session;
        if(Yii::$app->getRequest()->getQueryParam('SemesterForm')){
            $sem = Yii::$app->getRequest()->getQueryParam('SemesterForm');
            $semester->semester_id = $sem['semester_id'];
            $semester->str_search = $sem['str_search'];
            $session->set('semester', $sem['semester_id']);
        }else if($session->has('semester')){
            $semester->semester_id = $session->get('semester');
        }else{
            $semester->semester_id = Semester::getCurrentSemester()->id;
        }
        
        $searchModel = new HeadDepartmentSearch();
        $searchModel->semester = $semester->semester_id;
        $searchModel->search_course = $semester->str_search;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        
        return $this->render('head-department', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'semester' => $semester,
            'department' => $department
        ]);
    }

  
    
    public function actionCourseFilesCoorView($id)
    {
        $model = new Checklist();
        $modelOffer = $this->findOffered($id);

        return $this->render('course-files-coor-view', [
            'model' => $model,
            'modelOffer' => $modelOffer,
        ]);
    }

    protected function findOffered($id)
    {
        if (($model = CourseOffered::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	

    
}
