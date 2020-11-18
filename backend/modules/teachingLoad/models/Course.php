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
		return $this->hasMany(CourseOffered::className(), ['course_id' => 'id']);
	}


	public function getTeachLectureStr($br = "\n"){
		$list = $this->teachLecture;
		$str = '';
		if($list){
			$i = 1;
			foreach($list as $item){
				
				if($item->lectures){
					
					foreach ($item->lectures as $lecture) {
						
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
