<?php

namespace backend\modules\teachingLoad\models;

use Yii;
use yii\helpers\ArrayHelper;

class AssignmentService
{
    public $courses;

    public static function lecturerByOffer($offer_id){
        return CourseOffered::find()->alias('a')
        ->select('distinct(staff_id) as staff_id, count(lec_name) as lec_name')
         ->joinWith('courseLectures.lecturers')
        ->where(['a.id' => $offer_id])
        ->groupBy('staff_id')
        ->all();
    }

    public static function tutorByOffer($offer_id){
        return CourseOffered::find()->alias('a')
        ->select('distinct(staff_id) as staff_id, count(tutorial_name) as tutorial_name, count(lec_name) as lec_name')
       ->joinWith('courseLectures.lecTutorials.tutors')
        ->where(['a.id' => $offer_id])
         ->groupBy('staff_id')
        ->all();
    }

    public static function processStaffInvolveByOffer(CourseOffered $offer){
        $semester = $offer->semester_id;
        $lec = self::lecturerByOffer($offer->id);

         $tut = self::tutorByOffer($offer->id);

         $lec_arr = ArrayHelper::map($lec,'staff_id','staff_id');
         $tut_arr = ArrayHelper::map($lec,'staff_id','staff_id');

         //$staff = array_merge($lec_arr,$tut_arr);

         if($lec_arr)
         {
         	foreach ($lec_arr as $s) {
                if(!empty($s)){
					$inv = StaffInvolved::findOne(['staff_id' => $s, 'semester_id' => $semester]);
					if($inv === null){
						$new =  new StaffInvolved();
						$new->staff_id = $s;
						$new->semester_id = $semester;
						if(!$new->save())
						{
							print_r($new->getErrors());	
						}
						 $inv_id = $new->id;
					}
					else
					{
						$inv_id = $inv->id;
			
					}

				   self::processAppointLetter($s,$inv_id,$semester); 
			   }
         	
         	}
			
			// $to_del = StaffInvolved::find()->where(['staff_check' => 0, 'semester_id' => $semester])->all();
			// $arr = ArrayHelper::map($to_del, 'id' , 'id');
			// AppointmentLetter::deleteAll(['inv_id' => $arr]);
         	// StaffInvolved::deleteAll(['staff_check' => 0, 'semester_id' => $semester]);
         }

    }

    public static function processAppointLetterByOffer($offer, $s,$inv_id){
        $appoint = AppointmentLetter::findOne(['offered_id' => $offer, 'inv_id' => $inv_id]);
        if($appoint === null){
            $new =  new AppointmentLetter();
            $new->offered_id = $offer;
            $new->inv_id = $inv_id;

            if ($new->save()) {
                return true;
            }else{
                $new->flashError(); 
            }
            
        }
        return false;
    }
	
	public static function processStaffInvolve($semester){
        

    	 StaffInvolved::updateAll(['staff_check' => 0], ['semester_id' => $semester]);

    	 $staff = CourseOffered::find()
    	 ->select('distinct(staff_id) as staff_id, count(lec_name) as lec_name')
    	  ->joinWith('courseLectures.lecturers')
         ->where(['semester_id' => $semester])
		 ->groupBy('staff_id')
         ->all();

         $staff_tut = CourseOffered::find()
    	 ->select('distinct(staff_id) as staff_id, count(tutorial_name) as tutorial_name, count(lec_name) as lec_name')
    	->joinWith('courseLectures.lecTutorials.tutors')
         ->where(['semester_id' => $semester])
		  ->groupBy('staff_id')
         ->all();

         $staff = ArrayHelper::map($staff,'staff_id','staff_id');
         $staff_tut = ArrayHelper::map($staff_tut,'staff_id','staff_id');

         $staff = array_merge($staff,$staff_tut);
         
         if($staff)
         {
         	foreach ($staff as $s) {
                if(!empty($s)){
					$inv = StaffInvolved::findOne(['staff_id' => $s, 'semester_id' => $semester]);
					if($inv === null){
						$new =  new StaffInvolved();
						$new->staff_id = $s;
						$new->semester_id = $semester;
						$new->staff_check = 1;
						if(!$new->save())
						{
							print_r($new->getErrors());	
						}
						 $inv_id = $new->id;
					}
					else
					{
						$inv->staff_check = 1;
						$inv->save();
						$inv_id = $inv->id;
			
					}

				   self::processAppointLetter($s,$inv_id,$semester); 
			   }
         	
         	}
			
			$to_del = StaffInvolved::find()->where(['staff_check' => 0, 'semester_id' => $semester])->all();
			$arr = ArrayHelper::map($to_del, 'id' , 'id');
			AppointmentLetter::deleteAll(['inv_id' => $arr]);
         	StaffInvolved::deleteAll(['staff_check' => 0, 'semester_id' => $semester]);
         }
    	
    	
    	return true;
    }

    

    public static function processAppointLetter($s,$inv_id,$semester){
        
        AppointmentLetter::updateAll(['appoint_check' => 0], ['inv_id' => $inv_id]);
		 
        $staff_lec = CourseOffered::find()
        ->select('distinct(offered_id)')
        ->joinWith('courseLectures.lecturers')
        ->where(['semester_id' => $semester, 'staff_id' => $s])
        ->groupBy('offered_id')
        ->all();

        $staff_tut = CourseOffered::find()
        ->select('distinct(offered_id)')
        ->joinWith('courseLectures.lecTutorials.tutors')
        ->groupBy('offered_id')
        ->where(['semester_id' => $semester, 'staff_id' => $s])
        ->all();


        $staff_lec = ArrayHelper::map($staff_lec,'offered_id','offered_id');
        $staff_tut = ArrayHelper::map($staff_tut,'offered_id','offered_id');

        $staff = array_merge($staff_lec,$staff_tut);
       

       //run separately for lecture & tutorial
       
        if($staff_lec){
           foreach ($staff as $offer) {
               $appoint = AppointmentLetter::findOne(['offered_id' => $offer, 'inv_id' => $inv_id]);
               if($appoint === null){
                   $new =  new AppointmentLetter();
                   $new->offered_id = $offer;
                   $new->inv_id = $inv_id;
                   $new->appoint_check = 1;     
                   if(!$new->save()){
                      $new->flashError(); 
                   }
                    
               }else{
                   $appoint->appoint_check = 1;
                   $appoint->save();
               }
           }
        }
        
        if($staff_tut){
            foreach ($staff as $offer) {
                if(!in_array($offer, $staff_lec)){
                    $appoint = AppointmentLetter::findOne(['offered_id' => $offer, 'inv_id' => $inv_id]);
                    if($appoint === null){
                        $new =  new AppointmentLetter();
                        $new->offered_id = $offer;
                        $new->inv_id = $inv_id;
                        $new->tutorial_only = 1;
                        $new->appoint_check = 1;
                        if(!$new->save()){
                            $new->flashError();
                        }
                        
                    }else{
                        $appoint->appoint_check = 1;
                        $appoint->tutorial_only = 1;
                        $appoint->save();
                    }
                }else{

                }
                
            }
        }
        
        
        
       AppointmentLetter::deleteAll(['inv_id' => $inv_id, 'appoint_check' => 0]);
    }
    
    
}
