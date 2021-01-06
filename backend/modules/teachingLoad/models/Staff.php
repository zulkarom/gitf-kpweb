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
					$code = $item->courseLecture->courseOffered->course->course_code . ' ' . $item->courseLecture->courseOffered->course->course_name;
					$str .= $d.$code.' - '.$item->courseLecture->lec_name.' ('.$item->courseLecture->student_num.') ';
				}
			$i++;
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

	public function getTeachTutorialStr($semester,$br = "\n"){
		$this->semester = $semester;
		$list = $this->teachTutorial;
		$str = '';
		if($list){
			$i = 1;
			foreach($list as $item){
				
				if($item->tutorialLec){
					$d = $i == 1 ? '' : $br;
					$code = $item->tutorialLec->lecture->courseOffered->course->course_code;
					$codeLec = $item->tutorialLec->lecture->lec_name;
					$str .= $d.$code.' - '.$codeLec.$item->tutorialLec->tutorial_name.' ('.$item->tutorialLec->student_num.') ';
				}
				
			$i++;
			}
		}
		return $str;
	}

	public function getTotalLectureTutorial($br = "\n"){
		$list1 = $this->teachLecture;
		$countLecture = 0;
		if($list1){
			$i = 1;
			foreach($list1 as $item){
				
				if($item->courseLecture){
					$d = $i == 1 ? '' : $br;
					$countLecture++;
				}
				
			$i++;
			}
		}

		$list2 = $this->teachTutorial;
		$countTutorial = 0;
		if($list2){
			$j = 1;
			foreach($list2 as $item){
				
				if($item->tutorialLec){
					$d = $j == 1 ? '' : $br;
					$countTutorial++;
				}
				
			$j++;
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
