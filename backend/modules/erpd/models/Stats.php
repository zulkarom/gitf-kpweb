<?php

namespace backend\modules\erpd\models;

use Yii;

/**
 * Class Menu
 * Theme menu widget.
 */
class Stats
{
	public static function countMyResearch(){
		$kira = Research::find()
		->joinWith('researchers')
		->where(['staff_id' => Yii::$app->user->identity->staff->id, 'status' => 50])
		->count();
		return $kira;
	}
	
	public static function countMyCompletedResearch(){
		$kira = Research::find()
		->joinWith('researchers')
		->where(['staff_id' => Yii::$app->user->identity->staff->id, 'status' => 50, 'res_progress' => 1])
		->count();
		return $kira;
	}
	
	public static function countMyOnGoingResearch(){
		$kira = Research::find()
		->joinWith('researchers')
		->where(['staff_id' => Yii::$app->user->identity->staff->id, 'status' => 50, 'res_progress' => 0])
		->count();
		return $kira;
	}
	
	public static function countMyPublication(){
		$kira = Publication::find()
		->joinWith('pubTags')
		->where(['rp_pub_tag.staff_id' => Yii::$app->user->identity->staff->id, 'status' => 50])
		->count();
		return $kira;
	}
	
	public static function countMyMembership(){
		$kira = Membership::find()
		->where(['msp_staff' => Yii::$app->user->identity->staff->id, 'status' => 50])
		->count();
		return $kira;
	}
	
	public static function countMyAward(){
		$kira = Award::find()
		->where(['awd_staff' => Yii::$app->user->identity->staff->id, 'status' => 50])
		->count();
		return $kira;
	}
	
	public static function countMyConsultation(){
		$kira = Consultation::find()
		->where(['csl_staff' => Yii::$app->user->identity->staff->id, 'status' => 50])
		->count();
		return $kira;
	}
	
	public static function countMyKtp(){
		$kira = KnowledgeTransfer::find()
		->joinWith('members')
		->where(['rp_knowledge_transfer_member.staff_id' => Yii::$app->user->identity->staff->id, 'status' => 50])
		->count();
		return $kira;
	}
	
	public static function countTotalResearch(){
		$kira = Research::find()
		->joinWith('researchers')
		->where(['status' => 50])
		->count();
		return $kira;
	}
	
	public static function countTotalCompletedResearch(){
		$kira = Research::find()
		->joinWith('researchers')
		->where(['status' => 50, 'res_progress' => 1])
		->count();
		return $kira;
	}
	
	public static function countTotalOnGoingResearch(){
		$kira = Research::find()
		->joinWith('researchers')
		->where(['status' => 50, 'res_progress' => 0])
		->count();
		return $kira;
	}
	
	public static function countTotalPublication(){
		$kira = Publication::find()
		->joinWith('pubTags')
		->where(['status' => 50])
		->count();
		return $kira;
	}
	
	public static function countTotalMembership(){
		$kira = Membership::find()
		->where(['status' => 50])
		->count();
		return $kira;
	}
	
	public static function countTotalAward(){
		$kira = Award::find()
		->where(['status' => 50])
		->count();
		return $kira;
	}
	
	public static function countTotalConsultation(){
		$kira = Consultation::find()
		->where(['status' => 50])
		->count();
		return $kira;
	}
	
	public static function countTotalKtp(){
		$kira = KnowledgeTransfer::find()
		->joinWith('members')
		->where(['status' => 50])
		->count();
		return $kira;
	}
	
	public static function publicationLastFiveYears(){
		$curr_year = date('Y') + 0;
		$last_five = $curr_year - 5;
		
		return Publication::find()
		->select('sp_program.id, sp_program.pro_name as course_label, COUNT(sp_course.program_id) as course_data')
		->where(['pub_year' => 1, 'status' => 50])
		->groupBy('pub_year')
		->all();
		
	}
}
