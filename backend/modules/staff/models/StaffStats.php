<?php

namespace backend\modules\staff\models;

use Yii;

class StaffStats
{

	public static function staffByPosition(){
		return Staff::find()
		->select('staff_position.id, staff_position.position_name as position_name, COUNT(staff.position_id) as count_staff')
		->innerJoin('staff_position', 'staff_position.id = staff.position_id')
		->where(['staff.staff_active' => 1])
		->groupBy('staff.position_id')
		->orderBy('staff_position.position_order ASC')
		->all();
	}
	
	public static function staffByType(){
		return Staff::find()
		->select('staff.id, is_academic, COUNT(is_academic) as count_staff')
		->where(['staff.staff_active' => 1])
		->groupBy('is_academic')
		->orderBy('is_academic DESC')
		->all();
	}
	
	public static function staffByPositionStatus(){
		return Staff::find()
		->select('staff_position_status.id, staff_position_status.status_name as staff_label, COUNT(staff.position_status) as count_staff')
		->innerJoin('staff_position_status', 'staff_position_status.id = staff.position_status')
		->where(['staff.staff_active' => 1])
		->groupBy('staff.position_status')
		->orderBy('staff_position_status.status_order ASC')
		->all();
	}


}
