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
}
