<?php

namespace backend\modules\courseFiles\controllers;

use Yii;
use yii\web\Controller;
use backend\models\SemesterForm;
use backend\models\Semester;
use backend\modules\teachingLoad\models\Staff;
use backend\modules\courseFiles\models\CourseFilesSearch;
use backend\modules\courseFiles\models\Checklist;
use backend\modules\courseFiles\models\LectureCancel;
use backend\modules\teachingLoad\models\CourseOffered;
use backend\modules\teachingLoad\models\StaffInvolved;
use backend\modules\teachingLoad\models\CourseLecture;
use backend\modules\courseFiles\models\CoordinatorRubricsFile;

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

    public function actionTeachingAssignment(){
        
        $semester = new SemesterForm;

        if(Yii::$app->getRequest()->getQueryParam('SemesterForm')){
            $sem = Yii::$app->getRequest()->getQueryParam('SemesterForm');
            $semester->semester_id = $sem['semester_id'];
        }else{
            $semester->semester_id = Semester::getCurrentSemester()->id;
        }

        $model = new Staff();
        $modelItem = new Checklist();
        $model->semester = $semester->semester_id;
		$myInv = StaffInvolved::find(['staff_id' => Yii::$app->user->identity->staff->id, 'semester_id' => $semester->semester_id])->one();

        return $this->render('teaching-assignment', [
            'model' => $model,
            'modelItem' => $modelItem,
            'semester' => $semester,
			'myInv' => $myInv
        ]);


    }


    public function actionTeachingAssignmentLecture($id)
    {
        $model = new Checklist();
		
        $lecture = $this->findLecture($id);
		
        return $this->render('teaching-assignment-lecture', [
            'model' => $model,
            'lecture' => $lecture,
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
        $offer = $this->findOffered($id);
		$offer->scenario = 'coor';
		
		if ($offer->load(Yii::$app->request->post())) {
			if($offer->save()){
				Yii::$app->session->addFlash('success', "Data Updated");
			}else{
				$offer->flashError();
			}
		}
        
        return $this->render('teaching-assignment-coordinator', [
            'model' => $model,
            'offer' => $offer,
        ]);
    }
	
	protected function findOffered($id)
    {
        if (($model = CourseOffered::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	protected function findLecture($id)
    {
        if (($model = CourseLecture::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
