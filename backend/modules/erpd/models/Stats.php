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
	
	public static function countMyUnVerifiedResearch(){
		
		$kira = Research::find()
		->joinWith('researchers')
		->where(['staff_id' => Yii::$app->user->identity->staff->id])
		->andWhere(['<', 'status', 50])
		->count();
		return $kira;
	}
	
	public static function countStaffResearch($staff){
		$kira = Research::find()
		->joinWith('researchers')
		->where(['staff_id' => $staff, 'status' => 50])
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
	
	public static function countMyUnverifiedPublication(){
		$kira = Publication::find()
		->joinWith('pubTags')
		->where(['rp_pub_tag.staff_id' => Yii::$app->user->identity->staff->id])
		->andWhere(['<', 'status' , 50])
		->count();
		return $kira;
	}
	
	public static function countStaffPublication($staff){
		$kira = Publication::find()
		->joinWith('pubTags')
		->where(['rp_pub_tag.staff_id' => $staff, 'status' => 50])
		->count();
		return $kira;
	}
	
	public static function countPublicationByTypeYear($type, $year){
		$kira = Publication::find()
		->where(['status' => 50, 'pub_type' => $type, 'pub_year' => $year])
		->count();
		return $kira;
	}
	
	public static function countMyMembership(){
		$kira = Membership::find()
		->where(['msp_staff' => Yii::$app->user->identity->staff->id, 'status' => 50])
		->count();
		return $kira;
	}
	
	public static function countMyUnverifiedMembership(){
		$kira = Membership::find()
		->where(['msp_staff' => Yii::$app->user->identity->staff->id])
		->andWhere(['<', 'status' , 50])
		->count();
		return $kira;
	}
	
	public static function countStaffMembership($staff){
		$kira = Membership::find()
		->where(['msp_staff' => $staff, 'status' => 50])
		->count();
		return $kira;
	}
	
	public static function countMyAward(){
		$kira = Award::find()
		->where(['awd_staff' => Yii::$app->user->identity->staff->id, 'status' => 50])
		->count();
		return $kira;
	}
	
	public static function countMyUnverifiedAward(){
		$kira = Award::find()
		->where(['awd_staff' => Yii::$app->user->identity->staff->id])
		->andWhere(['<', 'status' , 50])
		->count();
		return $kira;
	}
	
	public static function countStaffAward($staff){
		$kira = Award::find()
		->where(['awd_staff' => $staff, 'status' => 50])
		->count();
		return $kira;
	}
	
	public static function countMyConsultation(){
		$kira = Consultation::find()
		->where(['csl_staff' => Yii::$app->user->identity->staff->id, 'status' => 50])
		->count();
		return $kira;
	}
	
	public static function countMyUnverifiedConsultation(){
		$kira = Consultation::find()
		->where(['csl_staff' => Yii::$app->user->identity->staff->id])
		->andWhere(['<', 'status' , 50])
		->count();
		return $kira;
	}
	
	public static function countStaffConsultation($staff){
		$kira = Consultation::find()
		->where(['csl_staff' => $staff, 'status' => 50])
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
	
	public static function countMyUnverifiedKtp(){
		$kira = KnowledgeTransfer::find()
		->joinWith('members')
		->where(['rp_knowledge_transfer_member.staff_id' => Yii::$app->user->identity->staff->id])
		->andWhere(['<', 'status' , 50])
		->count();
		return $kira;
	}
	
	public static function countStaffKtp($staff){
		$kira = KnowledgeTransfer::find()
		->joinWith('members')
		->where(['rp_knowledge_transfer_member.staff_id' => $staff, 'status' => 50])
		->count();
		return $kira;
	}
	
	public static function countTotalResearch($verified = true){
		$status = $verified ? 50 :  [20, 30] ;
		$kira = Research::find()
		->where(['status' => $status])
		->count();
		return $kira;
	}
	
	public static function countResearchByYear($year){
		return Research::find()
		->where(['status' => 50, 'YEAR(date_start)' => $year])
		->count();
	}
	
	public static function countTotalCompletedResearch(){
		$kira = Research::find()
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
	
	public static function countTotalPublication($verified = true){
		$status = $verified ? 50 :  [20, 30] ;
		$kira = Publication::find()
		->where(['status' => $status])
		->count();
		return $kira;
	}
	
	public static function countPublicationByYear($year){
		$kira = Publication::find()
		->where(['status' => 50, 'pub_year' => $year])
		->count();
		return $kira;
	}
	
	public static function countTotalMembership($verified = true){
		$status = $verified ? 50 :  [20, 30] ;
		$kira = Membership::find()
		->where(['status' => $status])
		->count();
		return $kira;
	}
	
	public static function countMembershipByYear($year){
		$kira = Membership::find()
		->where(['status' => 50, 'YEAR(date_start)' => $year])
		->count();
		return $kira;
	}
	
	public static function countTotalAward($verified = true){
		$status = $verified ? 50 :  [20, 30] ;
		$kira = Award::find()
		->where(['status' => $status])
		->count();
		return $kira;
	}
	
	public static function countAwardByYear($year){
		$kira = Award::find()
		->where(['status' => 50, 'YEAR(awd_date)' => $year])
		->count();
		return $kira;
	}
	
	public static function countTotalConsultation($verified = true){
		$status = $verified ? 50 :  [20, 30] ;
		$kira = Consultation::find()
		->where(['status' => $status])
		->count();
		return $kira;
	}
	
	public static function countConsultationByYear($year){
		$kira = Consultation::find()
		->where(['status' => 50, 'YEAR(date_start)' => $year])
		->count();
		return $kira;
	}
	
	public static function countTotalKtp($verified = true){
		$status = $verified ? 50 :  [20, 30] ;
		$kira = KnowledgeTransfer::find()
		->where(['status' => $status])
		->count();
		return $kira;
	}
	
	public static function countKtpByYear($year){
		$kira = KnowledgeTransfer::find()
		->where(['status' => 50, 'YEAR(date_start)' => $year])
		->count();
		return $kira;
	}
	
	public static function publicationLastFiveYears(){
		$curr_year = date('Y') + 0;
		$last_five = $curr_year - 4;
		
		return Publication::find()
		->select('id, pub_year as pub_label, COUNT(id) as pub_data')
		->where(['status' => 50])
		->andWhere(['>=', 'pub_year', $last_five])
		->andWhere(['<=', 'pub_year', $curr_year])
		->groupBy('pub_year')
		->all();
	}
	
	
	
	public static function researchLastFiveYears(){
		$curr_year = date('Y') + 0;
		$last_five = $curr_year - 4;
		return Research::find()
		->select('id, YEAR(date_start) as res_label, COUNT(id) as res_data')
		->where(['status' => 50])
		->andWhere(['>=', 'YEAR(date_start)', $last_five])
		->andWhere(['<=', 'YEAR(date_start)', $curr_year])
		->groupBy('YEAR(date_start)')
		->all();
	}
	
	public static function myPublicationLastFiveYears(){
		$curr_year = date('Y') + 0;
		$last_five = $curr_year - 4;
		return Publication::find()
		->select('rp_publication.id, pub_year as pub_label, COUNT(pub_year) as pub_data')
		->joinWith(['pubTags'])
		->where(['status' => 50, 'rp_pub_tag.staff_id' => Yii::$app->user->identity->staff->id])
		->andWhere(['>=', 'pub_year', $last_five])
		->andWhere(['<=', 'pub_year', $curr_year])
		->groupBy('pub_year')
		->all();
	}
	
	public static function myResearchLastFiveYears(){
		$curr_year = date('Y') + 0;
		$last_five = $curr_year - 4;
		return Research::find()
		->select('rp_research.id, YEAR(date_start) as res_label, COUNT(rp_research.id) as res_data')
		->joinWith(['researchers'])
		->where(['status' => 50, 'rp_researcher.staff_id' => Yii::$app->user->identity->staff->id])
		->andWhere(['>=', 'YEAR(date_start)', $last_five])
		->andWhere(['<=', 'YEAR(date_start)', $curr_year])
		->groupBy('YEAR(date_start)')
		->all();
	}
}
