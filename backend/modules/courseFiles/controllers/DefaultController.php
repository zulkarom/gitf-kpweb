<?php

namespace backend\modules\courseFiles\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;
use backend\models\SemesterForm;
use backend\models\Semester;

use backend\modules\students\models\Student;
use backend\modules\students\models\StudentSearch;

use backend\modules\teachingLoad\models\Staff;
use backend\modules\teachingLoad\models\CourseOffered;
use backend\modules\teachingLoad\models\StaffInvolved;
use backend\modules\teachingLoad\models\CourseLecture;
use backend\modules\teachingLoad\models\AppointmentLetter;

use backend\modules\courseFiles\models\Api;
use backend\modules\courseFiles\models\Checklist;
use backend\modules\courseFiles\models\LectureCancel;
use backend\modules\courseFiles\models\CoordinatorRubricsFile;
use backend\modules\courseFiles\models\StudentLecture;
use backend\modules\courseFiles\models\StudentLectureSearch;
use backend\modules\courseFiles\models\AddStudentLectureDateForm;
use backend\modules\courseFiles\models\pdf\AttendanceSummary;
use backend\modules\courseFiles\models\pdf\Clo;
use backend\modules\courseFiles\models\pdf\CloSummary;
use backend\modules\courseFiles\models\pdf\StudentList;
use backend\modules\courseFiles\models\excel\AssessmentExcel;

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
	
	
	public function actionTimetable(){
        
		$semester = Semester::getCurrentSemester()->id;
		
		$model = StaffInvolved::findOne(['staff_id' => Yii::$app->user->identity->staff->id, 'semester_id' => $semester]);

        return $this->render('timetable', [
			'model' => $model,
        ]);


    }
	
	public function actionStudentEvaluation($id){
		$model = $this->findAppointment($id);
        return $this->render('student-evaluation', [
			'model' => $model,
        ]);


    }
	
	protected function findAppointment($id)
    {
        if (($model = AppointmentLetter::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
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
				return $this->refresh();
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
	
	public function actionLectureStudentListPdf($id){
		$model = $this->findLecture($id);
		$pdf = new StudentList;
		$pdf->model = $model;
		$offer = $model->courseOffered;
		$pdf->course = $offer->course;
		$pdf->semester = $offer->semester;
		$pdf->group =  $model->lec_name;
		
		$pdf->generatePdf();
		
    }
	
	public function actionCloAnalysisPdf($id){
		$model = $this->findLecture($id);
		$pdf = new Clo;
		$pdf->model = $model;
		$offer = $model->courseOffered;
		$pdf->course = $offer->course;
		$pdf->semester = $offer->semester;
		$pdf->group =  $model->lec_name;
		$pdf->assessment = $offer->assessment;
		$pdf->listClo = $offer->listClo();
		
		$pdf->generatePdf();
	}
	
	public function actionCloSummaryPdf($id){
		$model = $this->findOffered($id);
		$pdf = new CloSummary;
		$pdf->model = $model;
		$pdf->course = $model->course;
		$pdf->semester = $model->semester;
		$pdf->listClo = $model->listClo();
		$pdf->generatePdf();
	}
	
	public function actionSaveClos($id){
		if(Yii::$app->request->post()){
			$model = $this->findLecture($id);
			$data = Yii::$app->request->post('achived');
			$model->clo_achieve = $data;
			$model->save();
		}
		
	}

    public function actionLectureStudentAssessment($id, $save = 0){
		$lecture = $this->findLecture($id);
		
		$kira = StudentLecture::find()->where(['lecture_id' => $id])->count();
        if($kira == 0){
			$this->importStudentListApi($lecture);
        }

        $searchModel = new StudentLectureSearch();
        $searchModel->lecture_id = $lecture->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		if(Yii::$app->request->post()){

            $data = Yii::$app->request->post('json_assessment');
            $data = json_decode($data);
			/* echo '<pre>';
			print_r($data);die(); */
            
            if($data){
                $i=0;
				$weight = $data[1];
				$full_mark = $data[2];
				
				$weight = array_slice($weight,3);
				$full_mark = array_slice($full_mark,3);
				
				
				
				//print_r($weight );die();
                foreach (array_slice($data,4) as $stud) {
                   if(is_array($stud) and $stud){
					   
						
	 			   		$matric = trim($stud[1]);
						$assess = array_slice($stud, 3);
						
/* 						 print_r($assess);
						print_r($weight);
						print_r($full_mark);
						die();  */
						$weighted_assess = array();
						$x = 0;
						foreach($assess as $raw){
							//print_r($weight);
							//echo $weight[$x];
							
							$s = $weight[$x];
							$sw = trim(str_replace('%', '', $weight[$x]));
							$w = $raw / $full_mark[$x] * $sw;
							$weighted_assess[] = $w;
						$x++;
						}
						//print_r($weighted_assess);
						//die();
                        $st_lec = StudentLecture::findOne(['matric_no' => $matric, 'lecture_id' => $id]);
                        if($st_lec){
                           $st_lec->assess_result = json_encode($weighted_assess);
                           $st_lec->save();
                        }
                    }
                    $i++;  
                    }  
                }
                Yii::$app->session->addFlash('success', "Import Excel Success"); 
				return $this->redirect(['lecture-student-assessment', 'id' => $id, 'save' => 1]);
            }
            
			
		//nak check ada data ke tak
		
        return $this->render('lecture-student-assessment', [
			'lecture' => $lecture,
            'dataProvider' => $dataProvider,
			'save' => $save
			
        ]);
		
    }

    public function actionExportExcel($id){
    	$lecture = $this->findLecture($id);

        $pdf = new AssessmentExcel;
        $pdf->model = $lecture;
        $pdf->generateExcel();
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
		die();  */
			
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
					$st = StudentLecture::findOne(['matric_no' => $matric, 'lecture_id' => $lecture->id]);

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
			
			if($data->result){
				$arr = array();
				foreach($data->result as $class){
					$arr[] = $class->date;
				}
				
				$lecture->attendance_header = json_encode($arr);
				$lecture->save();
			}
		}
		
		if(Yii::$app->request->post()){
			if($lecture->students){
			  foreach ($lecture->students as $student) {
				$val = Yii::$app->request->post('con_' . $student->matric_no);
				$student->attendance_check = $val;
				if(!$student->save()){
					Yii::$app->session->addFlash('error', "Saving failed for ".$student->matric_no);
				}
			  }
			}
			//die();
		}
		
        return $this->render('lecture-student-attendance', [
            'lecture' => $lecture,
        ]);
    }

    public function actionAttendanceSummaryPdf($id){
		$model = $this->findLecture($id);
	
		
		$pdf = new AttendanceSummary;
		$pdf->model = $model;
		// $pdf->response = $response;
		$pdf->course = $model->courseOffered->course;
		$pdf->semester = $model->courseOffered->semester;
		$pdf->group =  $model->lec_name;
		$pdf->generatePdf();
	}

    public function actionAttendanceSync($id){
    	
		$lecture = $this->findLecture($id);
		
		$api = new Api;
		$api->semester = $lecture->courseOffered->semester_id;
		$api->subject = $lecture->courseOffered->course->course_code;
		$api->group = $lecture->lec_name;
		$data = $api->attendList();
		if($data->result){
			$arr = array();
			foreach($data->result as $class){
				$arr[] = $class->date;
			}
			
			$lecture->attendance_header = json_encode($arr);
			$lecture->save();
		}
    	
		$api->semester = $lecture->courseOffered->semester_id;
		$api->subject = $lecture->courseOffered->course->course_code;
		$api->group = $lecture->lec_name;
		$response = $api->summary();

		 	$i=1;
            if($lecture->students){
              foreach ($lecture->students as $student) {
               		$array = array();

                      foreach($response->colums->result as $col){
                        $res = $response->attend[$col->id]->students[$student->matric_no]->status;
                        if(strtotime($col->date) <= time()){
                          
                          if($res == 1){
                            $hadir = 1;
                          }else{
                            $hadir = 0;
                          }
                        
                        }else{
                          $hadir = 0;
                        }
                        
    
                      $array[] = $hadir;
                      }
                    	$student->attendance_check = json_encode($array);
                    	$student->save();
                  $i++;
                	
              }
            }
            return $this->redirect(['lecture-student-attendance', 'id' => $id]);
    }

    public function actionLectureStudentAttendanceDate($id){
		$date = '2021-01-01';
		$year=date("Y",strtotime($date));
		$week =  date("W",strtotime($date));
		$dto = new \DateTime();
		echo $dto->setISODate($year, $week, 5)->format('Y-m-d');
	  	
	  
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
