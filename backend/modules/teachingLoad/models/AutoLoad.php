<?php

namespace backend\modules\teachingLoad\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use backend\modules\teachingLoad\models\Course;
use backend\modules\staff\models\Staff;

/**
 * This is the model class for table "tld_out_course".
 * @property int $id
 * @property int $staff_id
 * @property string $course_name
 */
class AutoLoad extends Model
{
	public $semester;
	public $max_hour;
	public $assign_log = array();
	
	public function runLoading(){
		$this->assign_log[] = 'Start running auto-load for semester ' . $this->semester;
		$this->max_hour = $this->maxHour;
		
		$random = $this->randomise();
		if($random[0] == 1){
			return $random[1];//error
		}if($random[0] == 2){
			$this->assign_log[] = 'This is a continuation of the previous auto-load running.';
		}else{
			$this->assign_log[] = 'Running fresh auto-load...';
		}
		
		//
		$staffs = $this->staffListRandom();
		if($staffs){
			foreach($staffs as $staff){
				//first round lecture
				if(!$this->assignFirstLecture($staff)){
					$staff->no_lecture = 1;
					$staff->save();
				}
			}
			///second round lecture
			$staffs = $this->staffListRandomHasLecture();
			if($staffs){
				foreach($staffs as $staff){
					if(!$this->findAndAssignLecture($staff)){
						$staff->no_lecture = 1;
						$staff->save();
					}
				}
			}
			
			///round first tutorial yg lecture sendiri
			$staffs = $this->staffListRandom();
			if($staffs){
				foreach($staffs as $staff){
					$this->assignTutorialOwnLecture($staff);
				}
			}
			
			///round second tutorial lecture lain current loading course
			$staffs = $this->staffListRandom();
			if($staffs){
				foreach($staffs as $staff){
					$this->assignTutorialOtherLectureSameCourse($staff);
				}
			}
			
			///round third tutorial lecture lain other able to teach course
			$staffs = $this->staffListRandom();
			if($staffs){
				foreach($staffs as $staff){
					$this->assignTutorialTeachLectureOtherCourse($staff);
				}
			}
			
			///round forth tutorial lecture lain other taught courses
			$staffs = $this->staffListRandom();
			if($staffs){
				foreach($staffs as $staff){
					$this->assignTutorialTaughtLectureOtherCourse($staff);
				}
			}
			
			//klu masih belum cukup max ejah lagi lecture available
			$staffs = $this->staffListRandomHasLecture();
			if($staffs){
				foreach($staffs as $staff){
					do {
					  $result = $this->findAndAssignLecture($staff);
					} while ($result and $this->staffStillNotMax($staff->staff_id));
				}
			}
			
		}
		$this->assign_log[] = 'Auto-load finished.';
		//$this->assign_log[] = 'Auto-load result : Assigning # coordinators, # lecturers and # tutors for # of courses offered with # active academic staff';
		return $this->assign_log;
	}
	
	public function assignTutorialTaughtLectureOtherCourse($staff){
		$list = $this->listCoursesTaughtOtherCourses($staff->staff_id);
		if($list){
			foreach($list as $course){
				$lectures = $this->listLectureByCourse($course->course_id);
				if($lectures){
					foreach($lectures as $lec){
						$this->addTutor($lec->id, $staff);
					}
				}
			}
		}
	}
	
	public function listCoursesTaughtOtherCourses($staff_id){
		$curr =  ArrayHelper::map($this->listStaffCurrentCourse($staff_id), 'course_id', 'course_id');
		$teach = ArrayHelper::map($this->listStaffTeachCourseSameCurrentCourse($staff_id), 'course_id', 'course_id');
		$previous = array_unique (array_merge ($curr, $teach));
		return TaughtCourse::find()
		->select('course_id')
		->where(['staff_id' => $staff_id])
		->andWhere(['not in', 'course_id', $previous])
		->all();
	}
	
	
	
	public function assignTutorialTeachLectureOtherCourse($staff){
		$list = $this->listStaffTeachCourseSameCurrentCourse($staff->staff_id);
		if($list){
			foreach($list as $course){
				$lectures = $this->listLectureByCourse($course->course_id);
				if($lectures){
					foreach($lectures as $lec){
						$this->addTutor($lec->id, $staff);
					}
				}
			}
		}
	}
	
	public function listStaffTeachCourseSameCurrentCourse($staff_id){
		$courses = ArrayHelper::map($this->listStaffCurrentCourse($staff_id), 'course_id', 'course_id');
		return TeachCourse::find()
		->where(['staff_id' => $staff_id])
		->andWhere(['not in', 'course_id', $courses])
		->orderBy('rank ASC')
		->all();
	}
	
	public function assignTutorialOtherLectureSameCourse($staff){
		$list = $this->listStaffCurrentOtherLecture($staff->staff_id);
		if($list){
			foreach($list as $lec){
				$this->addTutor($lec->lecture_id, $staff);
			}
		}else{
			return false;
		}
		return true;
		
	}
	
	public function assignTutorialOwnLecture($staff){
		
		$list = $this->listStaffCurrentLecture($staff->staff_id);
		if($list){
			foreach($list as $lec){
				$this->addTutor($lec->lecture_id, $staff);
			}
		}else{
			return false;
		}
		return true;
	}
	
	public function listStaffCurrentLecture($staff_id){
		return LecLecturer::find()
		->joinWith('courseLecture.courseOffered')
		->where(['staff_id' => $staff_id, 
			'semester_id' => $this->semester])
		->all();
	}
	
	public function listStaffCurrentOtherLecture($staff_id){
		$courses = ArrayHelper::map($this->listStaffCurrentCourse($staff_id), 'course_id', 'course_id');
		return LecLecturer::find()
		->joinWith('courseLecture.courseOffered')
		->where([
			'semester_id' => $this->semester,
			'course_id' => $courses 
			])
		->all();
	}
	
	public function listStaffCurrentCourse($staff_id){
		return LecLecturer::find()
		->select('course_id')
		->joinWith('courseLecture.courseOffered')
		->where(['staff_id' => $staff_id, 
			'semester_id' => $this->semester])
		->all();
	}
	
	public function staffCurrentLoading($staff_id){
		$lec = $this->countCurrentLecture($staff_id);
		$tut = $this->countCurrentTutorial($staff_id);
		$total = $lec * 2 + $tut;
		return $total;
	}
	
	public function staffStillNotMax($staff_id){
		$cur = $this->staffCurrentLoading($staff_id);
		$max = $this->staffMaxHour($staff_id);
		//echo $cur . '<' .  $max ;
		if($cur < $max){
			return true;
		}else{
			//update tem data
			$s = TemAutoLoad::findOne(['staff_id' => $staff_id]);
			$s->stop_run = 1;
			$s->save();
			return false;
		}
	}
	
	public function staffMaxHour($staff_id){
		$admin = MaximumHour::find(['staff_id' => $staff_id])->one();
		if($admin){
			return $admin->max_hour;
		}else{
			return $this->max_hour;
		}
	}
	
	public function getMaxHour(){
		return Setting::findOne(1)->max_hour;
	}
	
	public function findTemAutoload($staff_id){
		return TemAutoLoad::findOne(['staff_id' => $staff_id]);
	}
	
	public function assignFirstLecture($staff){
		//echo $this->countCurrentTutorial($staff->staff_id);die();
		//cari current lecture
		$lec = $this->countCurrentLecture($staff->staff_id);
		//klu belum ada lecture
		if($lec == 0){
			//cari choice
			return	$this->findAndAssignLecture($staff);
		}else{
			//dah ada
			return true;
		}
	}
	
	
	public function findAndAssignLecture($staff){
		for($i=1;$i<=4;$i++){
			$choice_avail = $this->findCourseChoice($staff->staff_id, $i);
			//print_r($first);die();
			if($choice_avail){
				$course_id = $choice_avail->course_id;
				//klu ada availabe slot masukkan jer
				if($this->addLecturer($course_id, $staff)){
					return true;
					break;
				}
			}
		}
		
		//cari yang already taught pulak
		$taughts = $this->listOtherTaughtCourse($staff->staff_id);
		if($taughts){
			foreach($taughts as $taught){
				if($this->addLecturer($taught->course_id, $staff)){
					return true;
					break;
				}
			}
		}
		return false;
	}
	
	
	
	public function listOtherTaughtCourse($staff_id){
		$array = array();
		$choice = TeachCourse::find()
		->select('course_id')
		->where(['staff_id' => $staff_id])
		->all();
		
		if($choice){
			foreach($choice as $c){
				$array[] = $c->course_id;
			}
		}
		
		return TaughtCourse::find()
		->where(['staff_id' => $staff_id])
		->andWhere(['not in', 'course_id', $array])
		->all();
	}
	
	public function countAllLecturersByCourse($course_id){
		return LecLecturer::find()
		->joinWith('courseLecture.courseOffered')
		->where(['course_id' => $course_id, 
			'semester_id' => $this->semester])
		->count();
	}
	
	public function assignCourseCoordinator($course_id, $staff){
		$offer = CourseOffered::findOne(['course_id' => $course_id, 'semester_id' => $this->semester]);
		$offer->coordinator = $staff->staff_id;
		$offer->save();
		$this->assign_log[] = $staff->staff->staff_no . ' ' . $staff->staff->staff_title . ' ' . $staff->staff->user->fullname . ' is assigned as a Coordinator for ' . $offer->course->course_name;
	}
	
	public function addLecturer($course_id, $staff){
		$lectures = $this->listLectureByCourse($course_id);
		$added = false;
		if($lectures){
			foreach($lectures as $lecture){
				//kena count overall lecturers ade ke tak
				$count_all = $this->countAllLecturersByCourse($course_id);
				if($count_all == 0){
					//lantik coor
					$this->assignCourseCoordinator($course_id, $staff);
				}
				
				$count_lecturer = count($lecture->lecturers);
				if($count_lecturer == 0){
					$lectr = new LecLecturer;
					$lectr->staff_id = $staff->staff_id;
					$lectr->lecture_id = $lecture->id;
					$lectr->save();
					$this->assign_log[] = $staff->staff->staff_no . ' ' . $staff->staff->staff_title . ' ' . $staff->staff->user->fullname . ' is assigned to Lecture ' . $lectr->courseLecture->courseOffered->course->course_name . ' ('.$lectr->courseLecture->lec_name.')'; 
					$added = true;
					//update max
					$this->staffStillNotMax($staff->staff_id);
					break;
				}
			}
		}
		return $added;
	}
	
	public function addTutor($lecture_id, $staff){
		$staff_id = $staff->staff_id;
		$tutorials = $this->listTutorialByLecture($lecture_id);
		if($tutorials){
			foreach($tutorials as $tutorial){
				$count_tutor = count($tutorial->tutors);
				if($count_tutor == 0){
					if($this->staffStillNotMax($staff_id)){
						$tutr = new TutorialTutor;
						$tutr->staff_id = $staff_id;
						$tutr->tutorial_id = $tutorial->id;
						$tutr->save();
						//update max
						$this->staffStillNotMax($staff->staff_id);
						$tutorial = $tutr->tutorialLec;
						$this->assign_log[] = $staff->staff->staff_no . ' ' . $staff->staff->staff_title . ' ' . $staff->staff->user->fullname . ' is assigned to Tutorial ' . $tutorial->lecture->courseOffered->course->course_name . ' ('.$tutorial->lecture->lec_name . $tutorial->tutorial_name . ')'; 
					}else{
						return false;
					}
					
				}
			}
		}
		return true;
	}
	
	public function listLectureByCourse($course_id){
		return CourseLecture::find()
		->joinWith('courseOffered')
		->where(['course_id' => $course_id, 'semester_id' => $this->semester])
		->all();
	}
	public function listTutorialByLecture($lecture_id){
		
		return TutorialLecture::find()
		->joinWith('lecture.courseOffered')
		->where(['lecture_id' => $lecture_id, 'semester_id' => $this->semester])
		->all();
		
	}
	
	public function findCourseChoice($staff_id, $rank){
		
		return TeachCourse::find()
		->where(['staff_id' => $staff_id, 'rank' => $rank])
		->one();
	}
	
	public function countCurrentLecture($staff_id){
		return LecLecturer::find()
		->joinWith('courseLecture.courseOffered')
		->where(['staff_id' => $staff_id, 
			'semester_id' => $this->semester])
		->count();
	}
	
	public function countCurrentTutorial($staff_id){
		return TutorialTutor::find()
		->joinWith('tutorialLec.lecture.courseOffered')
		->where(['staff_id' => $staff_id, 
			'semester_id' => $this->semester])
		->count();
	}
	
	public function randomise(){
		$staffs = $this->staffList();
		$array = ArrayHelper::map($staffs, 'id', 'id');
		shuffle($array);
		
		
		//kena check dulu ada data ke tak
		$count = TemAutoLoad::find()->count();
		if($count > 0){
			return [2, 'Delete current operation first.'];
		}
		
		$transaction = Yii::$app->db->beginTransaction();
        try {
			$flag = true;
			foreach($array as $staff){
				$load = new TemAutoLoad;
				$load->staff_id = $staff;
				if(!$load->save()){
					$flag = false;
					break;
				}
			}
            if($flag){
				$transaction->commit();
				$this->assign_log[] = 'Shuffling staff.';
				return [0, 'loading shuffled staff to temporary table successful.'];
			}
			
            
        }
        catch (Exception $e) 
        {
            $transaction->rollBack();
			return [1, 'Problem while load to database'];
        }

	}
	
	public function staffListRandom(){
		return TemAutoLoad::find()->where(['stop_run' => 0])->all();
	}
	
	public function staffListRandomHasLecture(){
		return TemAutoLoad::find()->where(['no_lecture' => 0, 'stop_run' => 0])->all();
	}
	
	public function staffList(){
		return Staff::find()
        ->joinWith('user')
        ->where(['staff_active' => 1, 'is_academic' => 1, 'working_status' => 1])
		->all();
	}
	
	public function courseList(){
		return Course::find()
		->where([
			'faculty_id' => Yii::$app->params['faculty_id'], 
			'is_active' => 1, 'is_dummy' => 0, 
			'method_type' => 1]
		);
	}
}

