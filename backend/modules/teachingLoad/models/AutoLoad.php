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
	
	
	public function runLoading(){
		$this->max_hour = $this->maxHour;
		$str = '';
		
		/* $random = $this->randomise();
		if($random[0] == 1){
			return $random[1];
		}else{
			return $random[1];
		} */
		
		//
		$staffs = $this->staffListRandom();
		if($staffs){
			foreach($staffs as $staff){
				//echo $staff->staff->user->fullname . ' - ' . $this->countCurrentTutorial($staff->staff_id);echo '<br/>'; continue;
				
				//first round lecture
				if(!$this->assignFirstLecture($staff)){
					$staff->no_lecture = 1;
					$staff->save();
				}
				///second round lecture
				if(!$this->assignSecondLecture($staff)){
					$staff->no_lecture = 1;
					$staff->save();
				}
				$this->assignTutorialOwnLecture($staff->staff_id);
				$this->assignTutorialOtherLectureSameCourse($staff->staff_id);
				$this->assignTutorialOtherLectureOtherCourse($staff->staff_id);
				//tutorial 
				//cari lecture sendiri klu ada
				
			}
		}
		return $str;
	}
	
	public function assignTutorialOwnLecture($staff){
		$list = listCurrentLecture($staff_id);
		if($list){
			foreach($list as $lec){
				//cari list tutorial yang available
			}
		}else{
			return false;
		}
	}
	
	public function listCurrentLecture($staff_id){
		return LecLecturer::find()
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
		//echo $cur . '<' .  $max ;die();
		if($cur < $max){
			return true;
		}else{
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
	
	public function assignSecondLecture($staff){
		//kena check jugak max 
		
		if($staff->no_lecture == 0){

			if($this->staffStillNotMax($staff->staff_id)){
				
				return	$this->findAndAssignLecture($staff);
			}
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
	
	public function addLecturer($course_id, $staff){
		$lectures = $this->listLectureByCourse($course_id);
		$added = false;
		if($lectures){
			foreach($lectures as $lecture){
				$count_lecturer = count($lecture->lecturers);
				if($count_lecturer == 0){
					$lectr = new LecLecturer;
					$lectr->staff_id = $staff->staff_id;
					$lectr->lecture_id = $lecture->id;
					$lectr->save();
					$added = true;
					break;
				}
			}
		}
		return $added;
	}
	
	public function addTutor($course_id, $staff){
		$lectures = $this->listLectureByCourse($course_id);
		$added = false;
		if($lectures){
			foreach($lectures as $lecture){
				$count_lecturer = count($lecture->lecturers);
				if($count_lecturer == 0){
					$lectr = new LecLecturer;
					$lectr->staff_id = $staff->staff_id;
					$lectr->lecture_id = $lecture->id;
					$lectr->save();
					$added = true;
					break;
				}
			}
		}
		return $added;
	}
	
	public function listLectureByCourse($course_id){
		return CourseLecture::find()
		->joinWith('courseOffered')
		->where(['course_id' => $course_id, 'semester_id' => $this->semester])
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
			return [1, 'Delete current operation first.'];
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
				return [0, 'loading shuffled staff to temporary table successful.'];
			}
			
            
        }
        catch (Exception $e) 
        {
            $transaction->rollBack();
			return [1, 'Problem while load to database'];
        }

	}
	
	public function firstRun(){

	}
	
	public function staffListRandom(){
		return TemAutoLoad::find()->all();
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

