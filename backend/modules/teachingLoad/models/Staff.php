<?php

namespace backend\modules\teachingLoad\models;

use Yii;

use yii\helpers\Url;


/**
 * This is the model class for table "staff_inv".
 *
 * @property int $id
 * @property int $staff_id
 * @property int $semester_id
 * @property string $timetable_file
 */
class Staff extends \backend\modules\staff\models\Staff
{
	public $semester;
	
	public function getTaughtCourses(){
		return $this->hasMany(TaughtCourse::className(), ['staff_id' => 'id']);
	}
	
	public function getTaughtCoursesStr($br = "\n"){
		$list = $this->taughtCourses;
		$str = '';
		if($list){
			$i = 1;
			foreach($list as $item){
				$d = $i == 1 ? '' : $br;
				$str .= $d.$item->course->codeAndCourse;
			$i++;
			}
		}
		return $str;
	}
	
	public function getTeachCourses(){
		return $this->hasMany(TeachCourse::className(), ['staff_id' => 'id'])->orderBy('rank ASC');
	}
	
	public function getTeachCoursesStr($br = "\n"){
		$list = $this->teachCourses;
		$str = '';
		if($list){
			$i = 1;
			foreach($list as $item){
				
				if($item->course){
					$d = $i == 1 ? '' : $br;
					$str .= $d.$item->course->codeAndCourse;
				}
				
			$i++;
			}
		}
		return $str;
	}

	// public function getCoordinator(){
	// 	return $this->hasOne(CourseOffered::className(),['coordinator' => 'id']);
	// }

	// public function getCoordinatorStr()
	// {
	// 	$str = '';
	// 	if($this->coordinator){
	// 		$str = $this->staff_title . ' ' . $this->user->fullname ;
	// 	}
	// 	return $str;
	// }


	public function getOffer($semester){
		return CourseOffered::find()
			->where(['course_id' => $this->id, 'semester_id' => $semester ])
			->one(); 
	}

	public function getCoordinatorStr($semester){
		$offer = $this->getOffer($semester);
		$coor = '';
		if($offer){
			$coordinator = $offer->coor;
			if($coordinator){
				$user = $coordinator->user;
				$coor = $coordinator->staff_title . ' ' . $user->fullname;
			}
			
		}
	return $coor; 
	}

	public function getCoordinatorIdentity(){
		return CourseOffered::find()
		->joinWith('course')
		->where(['coordinator' => Yii::$app->user->identity->staff->id , 'semester_id' => $this->semester])
		->all();
	}

	public function getTeachLectureIdentity(){
		return LecLecturer::find()
		->joinWith('courseLecture.courseOffered')
		->where(['staff_id' => Yii::$app->user->identity->staff->id , 'semester_id' => $this->semester])
		->all();
	}
	
   public function getTeachLecture(){
		return LecLecturer::find()
		->joinWith('courseLecture.courseOffered')
		->where(['staff_id' => $this->id, 'semester_id' => $this->semester])
		->all();
	}
	
	

	public function getTeachLectureStr($semester,$br = "\n"){
		$this->semester = $semester;
		$list = $this->teachLecture;
		$str = '';
		if($list){
			$i = 1;
			foreach($list as $item){
				if($item->courseLecture){
					$d = $i == 1 ? '' : $br;
					if($item->courseLecture->courseOffered){
						$code = $item->courseLecture->courseOffered->course->course_code . ' ' . $item->courseLecture->courseOffered->course->course_name;
						$str .= $d.$code.' - '.$item->courseLecture->lec_name.' ('.$item->courseLecture->student_num.') ';
						$i++;
					}
					
				}
			
			}
		}
		return $str;
	}

	public function getTeachTutorialIdentity(){
		return TutorialTutor::find()
		->joinWith('tutorialLec.lecture.courseOffered')
		->where(['staff_id' => Yii::$app->user->identity->staff->id, 'semester_id' => $this->semester])
		->all();
	}

	public function getTeachTutorial(){
		return TutorialTutor::find()
		->joinWith('tutorialLec.lecture.courseOffered')
		->where(['staff_id' => $this->id, 'semester_id' => $this->semester])
		->all();
	}
	
	public function getSumLectureHour(){
		return LecLecturer::find()
		->joinWith('courseLecture.courseOffered.course')
		->where(['staff_id' => $this->id, 'semester_id' => $this->semester])
		->sum('lec_hour');
	}
	
	public function getSumTutorialHour(){
		return TutorialTutor::find()
		->joinWith('tutorialLec.lecture.courseOffered.course')
		->where(['staff_id' => $this->id, 'semester_id' => $this->semester])
		->sum('tut_hour');
	}

	public function getTeachTutorialStr($semester,$br = "\n"){
		$this->semester = $semester;
		$list = $this->teachTutorial;
		$str = '';
		if($list){
			$i = 1;
			foreach($list as $item){
				
				if($item->tutorialLec){
					$d = $i == 1 ? '' : $br;
					if($item->tutorialLec->lecture->courseOffered){
						$code = $item
						->tutorialLec
						->lecture
						->courseOffered
						->course
						->course_code;
						$codeLec = $item->tutorialLec->lecture->lec_name;
						$str .= $d.$code.' - '.$codeLec.$item->tutorialLec->tutorial_name.' ('.$item->tutorialLec->student_num.') ';
						$i++;
					}
					
				}
				
			
			}
		}
		return $str;
	}
	
	public function getTotalLectureTutorialHour(){
		$lecture = $this->sumLectureHour;
		$tutorial = $this->sumTutorialHour;
		return $lecture + $tutorial;
	}
	
	public function getLabelTotalHours(){
		$load = $this->totalLectureTutorialHour;
		$max = $this->maxHourStaff;
		$accept = Setting::findOne(1)->accept_hour;
		if($load > $max){
			return '<span class="label label-warning">OVERLOAD</span>';
		}else if($load == $max){
			return '<span class="label label-success">MAXIMUM</span>';
		}else if($load >= $accept){
			return '<span class="label label-info">ACCEPTABLE</span>';
		}else{
			return '<span class="label label-danger">UNDERLOAD</span>';
		}
	}
	
	public function getMaxHourStaff(){
		$admin = MaximumHour::find()->where(['staff_id' => $this->id])->one();
		$general = Setting::findOne(1);
		if($admin){
			return $admin->max_hour;
		}else{
			return $general->max_hour;
		}
	}

	public function getTotalLectureTutorial($br = "\n"){
		$list1 = $this->teachLecture;
		$hours = 0;
		$countLecture = 0;
		if($list1){
			foreach($list1 as $item){
				if($item->courseLecture->courseOffered->course){
					$hours +=$item->courseLecture->courseOffered->course->lec_hour;
				}
			}
		}

		$list2 = $this->teachTutorial;
		$countTutorial = 0;
		if($list2){
			foreach($list2 as $item){
				if($item->tutorialLec){
					$countTutorial++;
				}
			}
		}
		$total = ($countLecture*2) + $countTutorial;
		$null ='';
		if($total){
			return $total;
		}
		else{
			return $null;
		}
	}
	
	public function getOtherTaughtCourses(){
		return $this->hasMany(OutCourse::className(), ['staff_id' => 'id']);
	}
	
	public function getOtherTaughtCoursesStr($br = "\n"){
		$list = $this->otherTaughtCourses;
		$str = '';
		if($list){
			$i = 1;
			foreach($list as $item){
				$d = $i == 1 ? '' : $br;
				$str .= $d.$item->course_name;
			$i++;
			}
		}
		return $str;
	}
	
	public function getPastExperiences(){
		return $this->hasMany(PastExperience::className(), ['staff_id' => 'id']);
	}
	
	public function getPastExperiencesStr($br = "\n"){
		$list = $this->pastExperiences;
		$str = '';
		if($list){
			$i = 1;
			foreach($list as $item){
				$d = $i == 1 ? '' : $br;
				$str .= $d. strtoupper(' - ' . $item->position . ' AT ' . $item->employer . ' ('.$item->start_end .')' );
			$i++;
			}
		}
		return $str;
	}
	
   
}
