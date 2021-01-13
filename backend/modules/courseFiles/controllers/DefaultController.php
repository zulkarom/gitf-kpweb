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
use backend\modules\students\models\Student;
use backend\modules\courseFiles\models\StudentLecture;
use backend\modules\courseFiles\models\StudentLectureSearch;
use yii\helpers\ArrayHelper;

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
	
	 public function actionLectureStudentList($id){
		$lecture = $this->findLecture($id);

        $searchModel = new StudentLectureSearch();
        $searchModel->lecture_id = $lecture->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);


        if(Yii::$app->request->post()){
            $data = Yii::$app->request->post('json_student');
            $data = json_decode($data);

            if($data){

                StudentLecture::updateAll(['stud_check' => 0]);

                $i=0;
                foreach (array_slice($data,1) as $stud) {
                     
                    $matric = $stud[0];
                    $name = $stud[1];
                    // echo "<pre>";
                    // print_r($matric);

                    if(!empty($stud)){
                        $st = Student::findOne(['matric_no' => $matric, 'st_name' => $name]);
                        if($st === null){
                           $new = new Student;
                           $new->matric_no = $matric;
                           $new->st_name = $name;
                           $new->complete = 0; 
                           if(!$new->save())
                            {
                                print_r($new->getErrors()); 
                            }
                           
                        }
                         
                         $this->checkStudentLec($matric,$lecture);
                        
                    }
                    $i++;    
                }
                  
            }
            Yii::$app->session->addFlash('success', "Import success");
        }
        return $this->render('lecture-student-list', [
			'lecture' => $lecture,
            'dataProvider' => $dataProvider,
        ]);
		
    }

    public function checkStudentLec($matric,$lecture)
    {

        $st = StudentLecture::findOne(['matric_no' => $matric]);

        if($st === null){
            $new = new StudentLecture;
            $new->lecture_id = $lecture->id;
            $new->matric_no = $matric;
            $new->stud_check = 1;
            if(!$new->save())
            {
                print_r($new->getErrors()); 
            }
        }
        else
        {
            $st->stud_check = 1;
            $st->save();
        }
        StudentLecture::deleteAll(['stud_check' => 0]);
    }

}
