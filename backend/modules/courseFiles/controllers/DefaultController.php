<?php

namespace backend\modules\courseFiles\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;
use backend\models\SemesterForm;
use backend\models\Semester;
use yii\db\Expression;

use backend\modules\students\models\Student;
use backend\modules\students\models\StudentSearch;
use backend\modules\courseFiles\models\DateSetting;
use backend\modules\teachingLoad\models\Staff;
use backend\modules\teachingLoad\models\CourseOffered;
use backend\modules\teachingLoad\models\StaffInvolved;
use backend\modules\teachingLoad\models\CourseLecture;
use backend\modules\teachingLoad\models\TutorialLecture;
use backend\modules\teachingLoad\models\AppointmentLetter;

use backend\modules\courseFiles\models\Api;
use backend\modules\courseFiles\models\Checklist;
use backend\modules\courseFiles\models\CoordinatorRubricsFile;
use backend\modules\courseFiles\models\StudentLecture;
use backend\modules\courseFiles\models\StudentTutorial;
use backend\modules\courseFiles\models\StudentLectureSearch;
use backend\modules\courseFiles\models\AddStudentLectureDateForm;
use backend\modules\courseFiles\models\pdf\AttendanceSummary;
use backend\modules\courseFiles\models\pdf\Clo;
use backend\modules\courseFiles\models\pdf\CloSummary;
use backend\modules\courseFiles\models\pdf\StudentList;
use backend\modules\courseFiles\models\excel\AssessmentExcel;
use yii\filters\AccessControl;
use backend\modules\courseFiles\models\excel\StudentExcel;
use backend\modules\esiap\models\Course;
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
	
	public function actionSubmitCourseFile($id){
		//sepatutnya kena check progress dulu
		$offer = $this->findOffered($id);
		$course = $offer->course;
		if($offer->prg_overall == 1){
			if($offer->status == 0){
				$offer->status = 10;
				$offer->submitted_at = new Expression('NOW()');
			}else if($offer->status == 20){
				$offer->status = 40;
			}
			
			if($offer->save()){
				Yii::$app->session->addFlash('success', "The course file for ".$course->course_code ." ". $course->course_name ." has been successfully submitted.");
				return $this->redirect(['teaching-assignment']);
				
			}
		}else{
			Yii::$app->session->addFlash('error', "The progress of course file must be 100% in order to submit.");
			return $this->redirect(['coordinator-view', 'id' => $id]);
		}
		
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
    public function actionTeachingAssignment(){
        $semester = new SemesterForm;
		$session = Yii::$app->session;
        if(Yii::$app->getRequest()->getQueryParam('SemesterForm')){
            $sem = Yii::$app->getRequest()->getQueryParam('SemesterForm');
            $semester->semester_id = $sem['semester_id'];
			$session->set('semester', $sem['semester_id']);
        }else if($session->has('semester')){
			$semester->semester_id = $session->get('semester');
		}else{
            $semester->semester_id = Semester::getCurrentSemester()->id;
        }

        $model = new Staff();
        $modelItem = new Checklist();
        $model->semester = $semester->semester_id;
		
		$dates = DateSetting::find()->where(['semester_id' => $semester->semester_id])->one();

		$myInv = StaffInvolved::findOne(['staff_id' => Yii::$app->user->identity->staff->id, 'semester_id' => $semester->semester_id]);

        return $this->render('teaching-assignment', [
            'model' => $model,
            'modelItem' => $modelItem,
            'semester' => $semester,
			'myInv' => $myInv,
			'dates' => $dates
        ]);


    }
    
    public function actionResources($id,$offer){
        $course = $this->findCourse($id);
        $offer = $this->findOffered($offer);
        return $this->render('resources', [
            'course' => $course,
            'offer' => $offer,
        ]);
    }
	
	
	public function actionTimetable($s, $back=false){
      
		$model = StaffInvolved::findOne(['staff_id' => Yii::$app->user->identity->staff->id, 'semester_id' => $s]);
		if($model){
				if($back){
				
				if(empty($model->timetable_file)){
					Yii::$app->session->addFlash('error', "No timetable file has been uploded!");
				}else{
					Yii::$app->session->addFlash('success', "Data Updated");
				}
			return $this->redirect(['default/teaching-assignment', 'SemesterForm[semester_id]' => $s]);
			}

			return $this->render('timetable', [
				'model' => $model,
			]);
		}
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
    
    protected function findCourse($id)
    {
        if (($model = Course::findOne($id)) !== null) {
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
        $tutorial = $this->findTutorial($id);
        return $this->render('teaching-assignment-tutorial', [
            'model' => $model,
            'tutorial' => $tutorial,
        ]);
    }
	
	public function actionCoordinatorView($id){
		$model = new Checklist();
		$offer = $this->findOffered($id);
		$offer->setProgressCoordinator();
		$offer->save();
		
		
		if ($offer->load(Yii::$app->request->post())) {
		    $course = $offer->course;
		    
		    
		    if($offer->coorsign_file){
		        if($offer->prg_overall == 1){
		            if($offer->status == 0){
		                $offer->status = 10;
		                $offer->submitted_at = new Expression('NOW()');
		            }else if($offer->status == 20){
		                $offer->status = 40;
		            }
		            
		            if($offer->save()){
		                Yii::$app->session->addFlash('success', "The course file for ".$course->course_code ." ". $course->course_name ." has been successfully submitted.");
		                return $this->redirect(['teaching-assignment']);
		                
		            }
		        }else{
		            Yii::$app->session->addFlash('error', "The progress of course file must be 100% in order to submit.");
		            return $this->redirect(['coordinator-view', 'id' => $id]);
		        }
		    }else{
		        Yii::$app->session->addFlash('error', "Kindly upload your signature");
		        return $this->redirect(['coordinator-view', 'id' => $id]);
		    }
		    
		    

		}
		    
		
		
		return $this->render('coordinator-view', [
            'model' => $model,
            'modelOffer' => $offer,
        ]);
	}

     public function actionTeachingAssignmentCoordinator($id)
    {
        $model = new Checklist();
        $offer = $this->findOffered($id);
        $offer2 = $this->findOffered($id);
		if(!in_array($offer->status, [0,20])){
			return $this->redirect(['coordinator-view', 'id' => $id]);
		}
		//$offer->scenario = 'coor';
		
		$dates = DateSetting::find()->where(['semester_id' => $offer->semester_id])->one();
		$ori_course_version = $offer->course_version;
		$ori_material_version = $offer->material_version;
		
		if ($offer->load(Yii::$app->request->post())) {
		    if($offer->course_version > 0){
		        //check dah submit ke belum
		        if($offer->courseVersion->status > 0){
		            $offer->progressCourseVersion = 1;
		        }else{
		            $offer->progressCourseVersion = 0.5;
		        }
		        
		    }else if($offer->course_version < 0){
		        $offer->course_version = $ori_course_version;
		    }else{
		        $offer->progressCourseVersion = 0;
		    }
		    
		    if($offer->material_version > 0){
		        //check ada file ke tak 
		        if($offer->material->items){
		            $offer->progressMaterial = 1;
		        }else{
		            $offer->progressMaterial = 0.5;
		        }
		        
		    }else if($offer->material_version < 0){
		         $offer->material_version = $ori_material_version;
		    }else{
		        $offer->progressMaterial = 0;
		    }
			
			
			if($offer->save()){
				Yii::$app->session->addFlash('success', "Information updated.");
				return $this->refresh();
				
			}else{
				$offer->flashError();
			}
		}
        
        return $this->render('teaching-assignment-coordinator', [
            'model' => $model,
            'offer' => $offer,
            'offer2' => $offer2,
			'dates' => $dates
        ]);
    }
	
	
	
	protected function findOffered($id)
    {
        if (($model = CourseOffered::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	protected function findTutorial($id)
    {
        if (($model = TutorialLecture::findOne($id)) !== null) {
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
		
		/* $kira = StudentLecture::find()->where(['lecture_id' => $id])->count();
        if($kira == 0){
			$this->importStudentListApi($lecture);
        } */
		
		if ($lecture->load(Yii::$app->request->post())) {
		    //print_r($selections = Yii::$app->request->post());
		    //die();
		    $selection = Yii::$app->request->post('selection');
		    if(StudentLecture::updateAll(['stud_group' => $lecture->assign_group], ['id' => $selection])){
		        Yii::$app->session->addFlash('success', "Data Updated");
		        return $this->refresh();
		        

		    }
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
	
	public function actionCloAnalysisPdf($id, $group = false){
		$model = $this->findLecture($id);
		$pdf = new Clo;
		$pdf->model = $model;
		$offer = $model->courseOffered;
		$pdf->course = $offer->course;
		$pdf->semester = $offer->semester;
		$pdf->group =  $model->lec_name;
		$pdf->assessment = $offer->assessment;
		$pdf->listClo = $offer->listClo();
		if($group == 1){
			$pdf->analysis_group = 1;
		}else if($group == 2){
			$pdf->analysis_group = 2;
		}
		
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
			$data2 = Yii::$app->request->post('achived2');
			$model->clo_achieve = $data;
			$model->clo_achieve2 = $data2;
			$model->save();
		}
		
	}

    public function actionLectureStudentAssessment($id, $save = 0){
		$lecture = $this->findLecture($id);
		
		/* $kira = StudentLecture::find()->where(['lecture_id' => $id])->count();
        if($kira == 0){
			$this->importStudentListApi($lecture);
        } */

        $searchModel = new StudentLectureSearch();
        $searchModel->lecture_id = $lecture->id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
		if(Yii::$app->request->post()){

            $data = Yii::$app->request->post('json_assessment');
            $data = json_decode($data);
			$progress = 0;
			/* echo '<pre>';
			print_r($data);die(); */
            
            if($data){
                //date validation first
                //kena buat max value la
				
                $i=0;
                $clo = array_slice($data[0], 3);
                $max = count($clo);
                //echo $max;die();
				$weight = $data[1];
				$full_mark = $data[2];
				
				$weight = array_slice($weight,3);
				$full_mark = array_slice($full_mark,3);
				
				foreach (array_slice($data,4) as $stud) {
				    if(is_array($stud) and $stud){
				        $assess = array_slice($stud, 3);
				        $t =0;
				        foreach($assess as $raw){
		
				            if($t < $max){ //verify good colum
				                if($full_mark[$t] == 0 or $full_mark[$t] == null){
				                    Yii::$app->session->addFlash('error', "Please check your excel, total mark must have a value or cannot be zero");
				                    return $this->redirect(['lecture-student-assessment', 'id' => $id]);
				                }
				                if($raw > $full_mark[$t]){
				                    Yii::$app->session->addFlash('error', "Please check your data, make sure the mark does not exceed the total mark");
				                    return $this->redirect(['lecture-student-assessment', 'id' => $id]);
				                }
				            } 
				            
				            $t++;
				        }
				    }
				
				}
			
				StudentLecture::updateAll(['assess_result' => ''],['lecture_id' => $id]);
				

                foreach (array_slice($data,4) as $stud) {
                   if(is_array($stud) and $stud){
					   
						
	 			   		$matric = trim($stud[1]);
						$assess = array_slice($stud, 3);
						
						$weighted_assess = array();
						$x = 0;
						foreach($assess as $raw){
							//print_r($raw);die();
							//echo $weight[$x];
						    if($x < $max){
						       // echo $t ;die();
						        $s = $weight[$x];
						        $sw = trim(str_replace('%', '', $weight[$x]));
						        
						        $w = $raw / $full_mark[$x] * $sw;
						        $weighted_assess[] = $w;
						    }
							
						$x++;
						}
						//print_r($weighted_assess);
						//die();
                        $st_lec = StudentLecture::findOne(['matric_no' => $matric, 'lecture_id' => $id]);
                        if($st_lec){
                           // echo $matric;echo json_encode($weighted_assess);die();
                           $st_lec->assess_result = json_encode($weighted_assess);
                           if($st_lec->save() and $weighted_assess){
                               
							   $progress++;
						   }
                        }
                    }
                    $i++;  
                    }  
                }
				$total = count($lecture->students);
				$dprogress = floor($progress / $total * 100);

				$re = $dprogress / 100;
				//echo $re ; die();
				$lecture->progressStudentAssessment = $re;
				//echo $lecture->prg_stu_assess;die();
				$lecture->save();
                Yii::$app->session->addFlash('success', "Import Marks done"); 
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
	
    public function actionExportExcelStudent($id){
        $lecture = $this->findLecture($id);
        
        $pdf = new StudentExcel();
        $pdf->model = $lecture;
        $pdf->generateExcel();
    }
	
	public function actionResyncStudent($id){
		$lecture = $this->findLecture($id);
		if($this->importStudentListApi($lecture)){
			Yii::$app->session->addFlash('success', "Data Updated");
			$lecture->progressStudentList = 1;
			$lecture->save();
		}
		return $this->redirect(['lecture-student-list', 'id' => $id]);
	}
	
	public function actionImportStudentListExcel($id){
	    $lecture = $this->findLecture($id);
	    
	    if(Yii::$app->request->post()){
	        $data = Yii::$app->request->post('json_student');
	        $data = json_decode($data);
	        
	        if($data){
	            
	            StudentLecture::updateAll(['stud_check' => 0], ['lecture_id' => $lecture->id]);

	            $i=0;
	            foreach (array_slice($data,1) as $stud) {
	                
	                if(is_array($stud) and array_key_exists(0,$stud)){
	                    
	                    $matric = trim($stud[0]);
	                    $name = $stud[1];
	                    
	                    $this->processAddingStudentLecture($lecture, $matric, $name);
	                    
	                    
	                }
	                $i++;
	            }
	            
	            StudentLecture::deleteAll(['stud_check' => 0]);
	            
	        }
	        
	        if($lecture->students){
	            $lecture->progressStudentList = 1;
	        }else{
	            $lecture->progressStudentList = 0;
	        }
	        
	        $lecture->save();
	        Yii::$app->session->addFlash('success', "Import success");
	        return $this->redirect(['lecture-student-list', 'id' => $id]);
	    }
	    
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
				
				$this->processAddingStudentLecture($lecture, $matric, $name);
					
				$i++;  
			}
			
			StudentLecture::deleteAll(['stud_check' => 0]);
			//update progress
			return true;
			
		}
		return false;
	}
	
	private function processAddingStudentLecture($lecture, $matric, $name){
	    $lvl = $lecture->courseOffered->course->study_level;
	    
	    $st = Student::findOne(['matric_no' => $matric, 'study_level' => $lvl]);
	    if($st === null){
	        $new = new Student;
	        $new->matric_no = $matric;
	        $new->st_name = $name;
	        $new->faculty_id = 0;
	        $new->study_level = $lvl;
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
	}
	
	public function importTutorialStudentListApi($tutorial){
		$api = new Api;
		$offer = $tutorial->lecture->courseOffered;
		$api->semester = $offer->semester_id;
		$api->subject = $offer->course->course_code;
		$api->group = $tutorial->tutorialGroup;
		$data = $api->student();
		/* echo '<pre>';
		print_r($data->result);
		die();  */
			
		if($data->result){

			StudentTutorial::updateAll(['stud_check' => 0], ['tutorial_id' => $tutorial->id]);

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
					   $new->faculty_id = 0;
					   if(!$new->save())
						{
							$new->flashError();
						}	   
					}	 
					$st = StudentTutorial::findOne(['matric_no' => $matric, 'tutorial_id' => $tutorial->id]);

					if($st === null){
						$new = new StudentTutorial;
						$new->tutorial_id = $tutorial->id;
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
			StudentTutorial::deleteAll(['stud_check' => 0]);
			//update progress
			return true;
			
		}
		return false;
	}
	
	public function actionDeleteStudentLecture($id, $lec){
		$model = StudentLecture::findOne(['id' => $id, 'lecture_id' => $lec]);
		if($model){
			if($model->delete()){
				Yii::$app->session->addFlash('success', "The student has been removed.");
			}
			//find tutorial student if exist
		}
		return $this->redirect(['lecture-student-list', 'id' => $lec]);
	}
	
	

    public function actionLectureStudentAttendance($id){
		$lecture = $this->findLecture($id);

		if(Yii::$app->request->post()){
		    
		    if(Yii::$app->request->post('pg')){
		        if($lecture->attendance_file){
		            
		            $lecture->progressStudentAttendance = 1;
		            
		        }else{
		            $lecture->progressStudentAttendance = 0;
		        }
		        
		        if ($lecture->save()) {
		            Yii::$app->session->addFlash('success', "Data Updated");
		            return $this->redirect(['default/teaching-assignment-lecture', 'id' => $id]);
		        }else{
		            $lecture->flashError();
		        }
		        
		    }else{
		        if($lecture->students){
		            foreach ($lecture->students as $student) {
		                $val = Yii::$app->request->post('con_' . $student->matric_no);
		                
		                $student->attendance_check = $val;
		                if(!$student->save()){
		                    Yii::$app->session->addFlash('error', "Saving failed for ".$student->matric_no);
		                }
		            }
		            
		        }
		        
		        if(Yii::$app->request->post('complete') == 1){
		            $lecture->progressStudentAttendance = 1;
		            $lecture->prg_attend_complete = 1;
		        }else{
		            $lecture->progressStudentAttendance = 0.5;
		            $lecture->prg_attend_complete = 0;
		        }
		        
		        if ($lecture->save()) {
		            Yii::$app->session->addFlash('success', "Data Updated");
		            return $this->redirect(['default/teaching-assignment-lecture', 'id' => $id]);
		        }else{
		            $lecture->flashError();
		        }
		    }
		    
			
			 
			
			//die();
		}
		
		$lvl = $lecture->courseOffered->course->study_level;
		
		if($lvl == 'UG'){
		    return $this->render('lecture-student-attendance', [
		        'lecture' => $lecture,
		    ]);
		}else{
		    return $this->render('lecture-student-attendance-pg', [
		        'lecture' => $lecture,
		    ]);
		}
        
    }
	
	public function actionTutorialStudentAttendance($id){
		$tutorial = $this->findTutorial($id);

		if(Yii::$app->request->post()){
			if($tutorial->students){
			  foreach ($tutorial->students as $student) {
				$val = Yii::$app->request->post('con_' . $student->matric_no);
				$student->attendance_check = $val;
				if(!$student->save()){
					Yii::$app->session->addFlash('error', "Saving failed for ".$student->matric_no);
				}
			  }
			  
			 
				
			}
			 if(Yii::$app->request->post('complete') == 1){
				$tutorial->progressStudentAttendance = 1;
				$tutorial->prg_attend_complete = 1;
			}else{
				$tutorial->progressStudentAttendance = 0.5;
				$tutorial->prg_attend_complete = 0;
			}
			if ($tutorial->save()) {
				Yii::$app->session->addFlash('success', "Data Updated");
				return $this->redirect(['default/teaching-assignment-tutorial', 'id' => $id]);
			}else{
				$tutorial->flashError();
			}
			//die();
		}
		
        return $this->render('tutorial-student-attendance', [
            'tutorial' => $tutorial,
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
	
	public function actionAttendanceSummaryTutorialPdf($id){
		$model = $this->findTutorial($id);
	
		
		$pdf = new AttendanceSummary;
		$pdf->model = $model;
		// $pdf->response = $response;
		$pdf->course = $model->lecture->courseOffered->course;
		$pdf->semester = $model->lecture->courseOffered->semester;
		$pdf->group =  $model->tutorialGroup;
		$pdf->generatePdf();
	}

    public function actionAttendanceSync($id){
    	
		$lecture = $this->findLecture($id);

		$api = new Api;
		$api->semester = $lecture->courseOffered->semester_id;
		$api->subject = $lecture->courseOffered->course->course_code;
		$api->group = $lecture->lec_name;
		$data = $api->attendList();
		if($data){
			if($data->result){
				$arr = array();
				foreach($data->result as $class){
					$arr[] = $class->date;
				}
				
				$lecture->attendance_header = json_encode($arr);
				$lecture->save();
			}
		}

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
			$lecture->prg_attend_complete = 0;
			$lecture->progressStudentAttendance = 0.5;
			$lecture->prg_attend_complete = 0;
			$lecture->save();
            return $this->redirect(['lecture-student-attendance', 'id' => $id]);
    }
	
	public function actionTutorialAttendanceSync($id){
    	
		$tutorial = $this->findTutorial($id);
		if(!$tutorial->students){
			$this->importTutorialStudentListApi($tutorial);
		}
		$tutorial = $this->findTutorial($id);

		$api = new Api;
		$api->semester = $tutorial->lecture->courseOffered->semester_id;
		$api->subject = $tutorial->lecture->courseOffered->course->course_code;
		$api->group = $tutorial->tutorialName;
		$data = $api->attendList();
		if($data){
			if($data->result){
				$arr = array();
				foreach($data->result as $class){
					$arr[] = $class->date;
				}
				
				$tutorial->attendance_header = json_encode($arr);
				$tutorial->save();
			}
		}

		$response = $api->summary();

		 	$i=1;
            if($tutorial->students){
              foreach ($tutorial->students as $student) {
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
			$tutorial->prg_attend_complete = 0;
			$tutorial->progressStudentAttendance = 0.5;
			$tutorial->prg_attend_complete = 0;
			$tutorial->save();
            return $this->redirect(['tutorial-student-attendance', 'id' => $id]);
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
    
    
    



}
