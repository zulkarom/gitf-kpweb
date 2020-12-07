<?php

namespace backend\modules\courseFiles\controllers;

use Yii;
use yii\web\Controller;
use backend\models\SemesterForm;
use backend\models\Semester;
use backend\modules\staff\models\Staff;
use backend\modules\courseFiles\models\CourseFilesSearch;
use backend\modules\courseFiles\models\Checklist;
use backend\modules\courseFiles\models\LectureCancel;
/**
 * Default controller for the `course-files` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $semester = new SemesterForm;
        $semester->action = ['/course-files/default/index'];

        if(Yii::$app->getRequest()->getQueryParam('SemesterForm')){
            $sem = Yii::$app->getRequest()->getQueryParam('SemesterForm');
            $semester->semester_id = $sem['semester_id'];
            $semester->str_search = $sem['str_search'];
        }else{
            $semester->semester_id = Semester::getCurrentSemester()->id;
        }

        $searchModel = new CourseFilesSearch();
        $searchModel->semester = $semester->semester_id;
        $searchModel->search_course = $semester->str_search;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'semester' => $semester
        ]);
    }

    public function actionViewFiles()
    {
        $model = new Checklist();
        return $this->render('viewfiles', [
            'model' => $model,
        ]);
    }

    public function actionTeachingAssignment(){
        
        $semester = new SemesterForm;
        $semester->action = ['/teaching-load/default/teaching-assignment'];

        if(Yii::$app->getRequest()->getQueryParam('SemesterForm')){
            $sem = Yii::$app->getRequest()->getQueryParam('SemesterForm');
            $semester->semester_id = $sem['semester_id'];
        }else{
            $semester->semester_id = Semester::getCurrentSemester()->id;
        }

        // print_r($semester->semester_id);
        // die();

        $model = new Staff();
        $modelItem = new Checklist();
        $model->semester = $semester->semester_id;

        return $this->render('teaching-assignment', [
            'model' => $model,
            'modelItem' => $modelItem,
            'semester' => $semester
        ]);


    }


    public function actionTeachingAssignmentLecture($id)
    {
        $model = new Checklist();
        $lecture_id = $id;
        return $this->render('teaching-assignment-lecture', [
            'model' => $model,
            'lecture_id' => $lecture_id,
        ]);
    }

    public function actionTeachingAssignmentTutorial($id)
    {
        $model = new Checklist();
        $tutorial_id = $id;
        return $this->render('teaching-assignment-tutorial', [
            'model' => $model,
            'tutorial_id' => $tutorial_id,
        ]);
    }

     public function actionTeachingAssignmentCoordinator($id)
    {
        $model = new Checklist();

        
        return $this->render('teaching-assignment-coordinator', [
            'model' => $model,
        ]);
    }

    public function actionTeachingAssignmentLectureUpload()
    {
    
        $model = new LectureCancel;
        return $this->render('teaching-assignment-lecture-upload', [
            'model' => $model,
        ]);
    }

}
