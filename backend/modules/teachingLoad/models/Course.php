<?php

namespace backend\modules\teachingLoad\models;

use Yii;

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
	
    /**
     * {@inheritdoc}
     */
	 
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
						
						if($lecture->lecturers){
							foreach ($lecture->lecturers as $lecturer){
								if($lecturer->staffName)
								{
									foreach ($lecturer->staffName as $staff)
										{
											$d = $i == 1 ? '' : $br;
											$code = $d.$lecture->lec_name.' ('.$lecture->student_num.') ';
											$str .= $code.' - '.$staff->staff_title . ' ' . $staff->user->fullname;
											$i++;
										}
								}
							}
						}else{
							$d = $i == 1 ? '' : $br;
							$code = $d.$lecture->lec_name.' ('.$lecture->student_num.') ';
							$str .= $code.' - <span class="label label-danger">???</span>';
							$i++;
						}
						
						
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
							
							foreach ($lecture->tutorials as $tutorial) {
								
								
								
								if($tutorial->lecturers)
								{
									foreach ($tutorial->lecturers as $lecturer)
									{
										if($lecturer->staffName){
											foreach ($lecturer->staffName as $staff)
											{
												$d = $i == 1 ? '' : $br;
												$code = $d.$lecture->lec_name.$tutorial->tutorial_name.' ('.$tutorial->student_num.') ';
												$str .= $code.' - '.$staff->staff_title . ' ' . $staff->user->fullname;
												$i++;
											}
										}
									}
								}else{
									$d = $i == 1 ? '' : $br;
									$code = $d.$lecture->lec_name.$tutorial->tutorial_name.' ('.$tutorial->student_num.') ';
									$str .= $code.' - <span class="label label-danger">???</span>';
									$i++;
								}
								
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
}
