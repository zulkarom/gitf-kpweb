<?php

namespace backend\modules\courseFiles\controllers;

use Yii;
use yii\web\Controller;
use backend\models\SemesterForm;
use backend\models\Semester;
use backend\modules\teachingLoad\models\Staff;
use backend\modules\courseFiles\models\Api;
use backend\modules\courseFiles\models\CourseFilesSearch;
use backend\modules\courseFiles\models\Checklist;
use backend\modules\courseFiles\models\LectureCancel;
use backend\modules\teachingLoad\models\CourseOffered;
use backend\modules\teachingLoad\models\StaffInvolved;
use backend\modules\teachingLoad\models\CourseLecture;
use backend\modules\courseFiles\models\CoordinatorRubricsFile;
use backend\modules\students\models\Student;
use backend\modules\students\models\StudentSearch;
use backend\modules\courseFiles\models\StudentLecture;
use backend\modules\courseFiles\models\StudentLectureSearch;
use backend\modules\courseFiles\models\AddStudentLectureDateForm;
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

		$myInv = StaffInvolved::findOne(['staff_id' => Yii::$app->user->identity->staff->id, 'semester_id' => $semester->semester_id]);

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
		
		$kira = StudentLecture::find()->where(['lecture_id' => $id])->count();
        if($kira == 0){
			$this->importStudentListApi($lecture);

        }

        $searchModel = new StudentLectureSearch();
        $searchModel->lecture_id = $lecture->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		
		
		//nak check ada data ke tak
		
        return $this->render('lecture-student-list', [
			'lecture' => $lecture,
            'dataProvider' => $dataProvider,
			
        ]);
		
    }
	
	public function actionResyncStudent($id){
		$lecture = $this->findLecture($id);
		$this->importStudentListApi($lecture);
		return $this->redirect(['lecture-student-list', 'id' => $id]);
	}
	
	public function importStudentListApi($lecture){
		$api = new Api;
		$api->semester = $lecture->courseOffered->semester_id;
		$api->subject = $lecture->courseOffered->course->course_code;
		$api->group = $lecture->lec_name;
		$data = $api->student();
		/* echo '<pre>';
		print_r($data->result);
		die(); */
			
		if($data->result){

			StudentLecture::updateAll(['stud_check' => 0], ['lecture_id' => $lecture->id]);

			$i=0;
			foreach ($data->result as $stud) {
				$matric = trim($stud->id);
				$name = $stud->name;
					
					$st = Student::findOne(['matric_no' => $matric]);
					if($st === null){
					   $new = new Student;
					   $new->matric_no = $matric;
					   $new->st_name = $name;
					   $new->complete = 0; 
					   if(!$new->save())
						{
							$new->flashError();
						}
					   
					}
					 
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
					
					
					
				
				$i++;  
				
				
				
			}
			
			StudentLecture::deleteAll(['stud_check' => 0]);

		}
	}
	
	 public function importStudentListExcel($id){
		$lecture = $this->findLecture($id);

        $searchModel = new StudentLectureSearch();
        $searchModel->lecture_id = $lecture->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
        if(Yii::$app->request->post()){
            $data = Yii::$app->request->post('json_student');
            $data = json_decode($data);

            if($data){

                StudentLecture::updateAll(['stud_check' => 0], ['lecture_id' => $id]);

                $i=0;
                foreach (array_slice($data,1) as $stud) {
					
                    if(is_array($stud) and array_key_exists(0,$stud)){
						
					$matric = trim($stud[0]);
                    $name = $stud[1];
						
                        $st = Student::findOne(['matric_no' => $matric]);
                        if($st === null){
                           $new = new Student;
                           $new->matric_no = $matric;
                           $new->st_name = $name;
                           $new->complete = 0; 
                           if(!$new->save())
                            {
                                $new->flashError();
                            }
                           
                        }
                         
                         $this->checkStudentLec($matric,$lecture);
                        
                    }
                    $i++;    
                }
                  
            }
            Yii::$app->session->addFlash('success', "Import success");
			return $this->refresh();
        }
        return $this->render('lecture-student-list', [
			'lecture' => $lecture,
            'dataProvider' => $dataProvider,
			
        ]);
		
    }

    public function actionLectureStudentAttendance($id){
		$lecture = $this->findLecture($id);
		if(empty($lecture->attendance_header)){
			$api = new Api;
			$api->semester = $lecture->courseOffered->semester_id;
			$api->subject = $lecture->courseOffered->course->course_code;
			$api->group = $lecture->lec_name;
			$data = $api->attendList();
			/* echo '<pre>';
			print_r($data->result);
			die();  */
			
			if($data->result){
				$arr = array();
				foreach($data->result as $class){
					$arr[] = $class->date;
				}
				
				$lecture->attendance_header = json_encode($arr);
				$lecture->save();
			}
		}
		
        


        return $this->render('lecture-student-attendance', [
            'lecture' => $lecture,
        ]);
    }

    public function actionLectureStudentAttendanceDate($id){
		$date = '2021-01-01';
		$year=date("Y",strtotime($date));
		$week =  date("W",strtotime($date));
		$dto = new \DateTime();
		echo $dto->setISODate($year, $week, 5)->format('Y-m-d');
	  die();
	  
	  
        $model = new AddStudentLectureDateForm;
		$lecture = $this->findLecture($id);
        //$startdate = '2014-05-17';
		//$number = 14;
		
		if ($model->load(Yii::$app->request->post())) {
			$startdate = $model->start_date;
			$exdate = $model->exclude_date;
			$number = $model->number_of_class;
			//echo $startdate;echo $number;
			$data = $this->getSundays($startdate, $number, $exdate);
			$lecture->attendance_header = json_encode($data);
			if($lecture->save()){
				return $this->refresh();
			}
			
		}
        
        return $this->render('lecture-student-attendance-form-date', [
            'lecture' => $lecture,
            'model' => $model,
        ]);
    }

   

    private function getSundays($startdate, $number, $exclude_date) {
        $firstOfMonth = date("Y-m-01", strtotime(str_replace('-','/',$startdate)));
        
        $startweek=date("W",strtotime($startdate));

        $year=date("Y",strtotime($startdate));
		$arr = array();
		$arr[] = $startdate;
		$day = date("w",strtotime($startdate));
		$limit = $startweek + $number - 1;
		
        for($i=$startweek;$i<=$limit;$i++) {
            $result=$this->getWeek($i,$year, $day);
            if($result>$startdate) {
                $arr[] =  $result;
            }
        }
		return $arr;
    }

    private function getWeek($week, $year, $day) {
      $dto = new \DateTime();
	  echo $year. $week. $day;
      $result = $dto->setISODate($year, $week, $day)->format('Y-m-d');
      return $result;
    }

    public function checkStudentLec($matric,$lecture)
    {

        
    }

}
