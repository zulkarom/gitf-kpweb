<?php

namespace backend\modules\teachingLoad\models;

use Yii;
use backend\modules\courseFiles\models\Material;
use backend\models\Semester;

/**
 * This is the model class for table "tld_out_course".
 *
 * @property int $id
 * @property int $staff_id
 * @property string $course_name
 */
class Course extends \backend\modules\esiap\models\Course
{
	public $semester;
	public $page;
	public $perpage;
	
    /**
     * {@inheritdoc}
     */
	public function rules(){
		$rules = parent::rules();
		$rules[] = [['lec_hour', 'tut_hour'], 'required', 'on' => 'contact_hour'];
		
		$rules[] = [['page', 'perpage'], 'integer'];
		
		
		return $rules;
	}
	 
    public function getStaffTeachers(){
		return $this->hasMany(TeachCourse::className(), ['course_id' => 'id'])->orderBy('rank ASC');
	}
	
	public function getStaffStr($br = "\n"){
		$list = $this->staffTeachers;
		$str = '';
		foreach($list as $item){
			$str .= '['.$item->rank . '] '  . $item->staff->niceName . $br;
		}
		
		return $str;
		
	}
	
	public function getTeachLecture(){
		return $this->hasMany(CourseOffered::className(), ['course_id' => 'id'])->where(['semester_id' => $this->semester]);
	}

	public function getOffer($semester){
			return CourseOffered::find()
				->where(['course_id' => $this->id, 'semester_id' => $semester ])
				->one(); 
	}


	public function getCourse(){
		return CourseOffered::find()
		->where(['semester_id' => $this->semester])
		->all();
	}
	
	public function currentCoordinator(){
		$result = CourseOffered::find()
				->joinWith('semester')
				->where(['course_id' => $this->id, 'is_current' => 1 ])
				->one(); 
		if($result){
			return $result->coordinator;
		}
		
		return false;
		
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

	public function getTeachLectureStr($semester, $br = "\n"){
		$this->semester = $semester;
		$list = $this->teachLecture;
		$str = '';
		if($list){
			$i = 1;
			foreach($list as $item){
				
				if($item->lectures){
					
					foreach ($item->lectures as $lecture) {
						$d = $i == 1 ? '' : $br;
						$str .= $d.$lecture->lec_name.' ('.$lecture->student_num.') - ';
						$str_lec = '';
						$i++;
						
						if($lecture->lecturers){
							$x = 1;
							foreach ($lecture->lecturers as $lecturer){
								if($lecturer->staff){
									$slash = $x == 1 ? '' : '/';
									$str_lec .= $slash .  ' ' .$lecturer->staff->staff_title . ' ' . $lecturer->staff->user->fullname . ' ';
									$x++;
								}
								
							}
							
						}else{
							$str_lec .= '<span class="label label-danger">???</span>';
						}
						
						$str .= $str_lec;
						
					}	
				}
			}
		}
		return $str;
	}

	public function getTeachTutorialStr($br = "\n"){
		$list = $this->teachLecture;
		$str = '';
		if($list){
			$i = 1;
			foreach($list as $item){
				if($item->lectures){
					foreach ($item->lectures as $lecture) {
						if($lecture->tutorials){
							
							foreach ($lecture->tutorials as $tutorial){
								
								$d = $i == 1 ? '' : $br;
								$str .= $d.$lecture->lec_name . $tutorial->tutorial_name.' ('.$tutorial->student_num.') - ';
								$i++;
								$str_tut = '';
								if($tutorial->tutors){
									$x = 1;
									foreach ($tutorial->tutors as $tutor){
										$slash = $x == 1 ? '' : '/';
										$str_tut .= $slash .  ' ' .$tutor->staff->staff_title . ' ' . $tutor->staff->user->fullname . ' ';
										$x++;
									}
								}else{
									$str_tut .= '<span class="label label-danger">???</span>';
								}
								$str .= $str_tut;
							}
							
						}
					}
			
				}

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
				
				if($item->lectures){
					$d = $i == 1 ? '' : $br;
					foreach ($item->lectures as $lecture) {
						$countLecture++;
					}	
				}
				
			$i++;
			}
		}

		$list2 = $this->teachLecture;
		$countTutorial = 0;
		if($list2){
			$j = 1;
			foreach($list2 as $item){
				
				if($item->lectures){
					$d = $j == 1 ? '' : $br;
					foreach ($item->lectures as $lecture) {
					
						if($lecture->tutorials){
							foreach ($lecture->tutorials as $tutorial) {
								$countTutorial++;
							
							}
						}
					}
					
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
	public function getMaterials(){
		return $this->hasMany(Material::className(), ['course_id' => 'id']);
	}
	
	public function getMaterialCourseFile(){
	    return $this->hasMany(Material::className(), ['course_id' => 'id'])->where(['mt_type' => 1]);
	}
	
	public function getMaterialSubmit(){
		return $this->hasMany(Material::className(), ['course_id' => 'id'])->where(['status' => 10, 'mt_type' => 1]);
	}
	
	
}
