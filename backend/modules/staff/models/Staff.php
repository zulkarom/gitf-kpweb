<?php

namespace backend\modules\staff\models;

use Yii;
use common\models\User;
use yii\helpers\ArrayHelper;
use backend\modules\erpd\models\Stats as ErpdStats;
use backend\modules\teachingLoad\models\TaughtCourse;
use backend\modules\teachingLoad\models\TeachCourse;
use backend\modules\teachingLoad\models\LecLecturer;
use backend\modules\teachingLoad\models\TutorialTutor;
use backend\modules\teachingLoad\models\OutCourse;
use backend\modules\teachingLoad\models\PastExperience;
use common\models\Country;

/**
 * This is the model class for table "staff".
 *
 * @property int $id
 * @property int $user_id
 * @property string $staff_no
 * @property string $staff_name
 * @property string $staff_title
 * @property string $staff_edu
 * @property int $is_academic
 * @property int $position_id
 * @property int $position_status
 * @property int $working_status
 * @property string $leave_start
 * @property string $leave_end
 * @property string $leave_note
 * @property string $rotation_post
 * @property string $staff_expertise
 * @property string $staff_gscholar
 * @property string $officephone
 * @property string $handphone1
 * @property string $handphone2
 * @property string $staff_ic
 * @property string $staff_dob
 * @property string $date_begin_umk
 * @property string $date_begin_service
 * @property string $staff_note
 * @property string $personal_email
 * @property string $ofis_location
 * @property string $staff_cv
 * @property string $image_file
 * @property string $staff_interest
 * @property int $staff_department
 * @property int $publish
 * @property int $staff_active
 */
class Staff extends \yii\db\ActiveRecord
{
	public $staff_name;
	public $email;
	public $staffid;
	public $fullname;
	public $stitle;
	
	public $image_instance;
	public $file_controller;
	
	public $count_staff;
	public $position_name;
	public $staff_label;

	
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'staff';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['staff_no', 'user_id', 'staff_title', 'is_academic', 'position_id', 'position_status', 'working_status'], 'required'],
			
			[['teaching_submit'], 'required', 'on' => 'teaching'],
			
			[['user_id'], 'required', 'on' => 'reload'],
			
			[['email'], 'email'],
			
			['staff_no', 'unique', 'targetClass' => '\backend\modules\staff\models\Staff', 'message' => 'This staff no has already been taken'],
			
			//['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email has already been taken'],
			
			
            [['user_id', 'is_academic', 'position_id', 'position_status', 'working_status',  'staff_department', 'publish', 'staff_active', 'hq_year', 'teaching_submit'], 'integer'],
			
            [['leave_start', 'leave_end', 'staff_dob', 'date_begin_umk', 'date_begin_service', 'teaching_submit_at'], 'safe'],
			
            [['leave_note', 'staff_interest', 'research_focus' ], 'string'],
			
            [['staff_no', 'nationality', 'high_qualification', 'hq_country'], 'string', 'max' => 10],
			
			
            [['staff_note', 'personal_email', 'ofis_location', 'hq_specialization'], 'string', 'max' => 100],
            [['staff_title', 'officephone', 'handphone1', 'handphone2'], 'string', 'max' => 20],
			
            [['staff_edu', 'staff_expertise', 'staff_cv', 'hq_institution'], 'string', 'max' => 300],
			
            [['rotation_post', 'staff_gscholar'], 'string', 'max' => 500],
			
            [['staff_ic'], 'string', 'max' => 15],
			
			[['image_file'], 'required', 'on' => 'image_upload'],
            [['image_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg, png, bmp, gif', 'maxSize' => 1000000],
            [['updated_at'], 'required', 'on' => 'image_delete'],


        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'staff_no' => 'Staff No',
            'staff_title' => 'Staff Designation',
            'staff_edu' => 'Staff Education (abbr.)',
            'is_academic' => 'Type',
            'position_id' => 'Position',
            'position_status' => 'Position Status',
            'working_status' => 'Working Status',
            'leave_start' => 'Leave Start',
            'leave_end' => 'Leave End',
            'leave_note' => 'Leave Note',
            'rotation_post' => 'Rotation Post',
            'staff_expertise' => 'Staff Expertise',
            'staff_gscholar' => 'Staff Google Scholar',
            'officephone' => 'Office Phone',
            'handphone1' => 'Handphone1',
            'handphone2' => 'Handphone2',
            'staff_ic' => 'Staff NRIC',
            'staff_dob' => 'Staff D.O.B',
            'date_begin_umk' => 'Date Begin UMK',
            'date_begin_service' => 'Date Begin Service',
            'staff_note' => 'Staff Note',
            'personal_email' => 'Personal Email',
            'ofis_location' => 'Office Location',
            'staff_cv' => 'Staff CV',
            'image_file' => 'Staff Image',
            'staff_level' => 'Staff Level',
            'staff_interest' => 'Staff Interest',
            'staff_department' => 'Staff Department',
            'publish' => 'Publish',
            'staff_active' => 'Staff Active',
            'user_token' => 'User Token',
            'user_token_at' => 'User Token At',
			'hq_specialization' => 'Specialization',
			'hq_institution' => 'Awarding Institution',
			'hq_country' => 'Country',
        ];
    }
	
	public function getNiceName(){
		return $this->staff_title . ' ' . $this->user->fullname;
	}
	
	public function getListTitles(){
		$array = ['Encik','Cik', 'Puan' ,'Dr.', 'Prof. Madya', 'Prof. Madya Dr.', 'Prof.', 'Prof. Dr.'];
		$return = [];
		foreach($array as $a){
			$return[$a] = $a;
		}
		$return[999] = 'Others (Please specify...)';
		return $return;
	}
	
	public function getStaffPosition(){
		return $this->hasOne(StaffPosition::className(), ['id' => 'position_id']);
	}
	
	public function getStaffPositionStatus(){
		return $this->hasOne(StaffPositionStatus::className(), ['id' => 'position_status']);
	}
	
	public function getWorkingStatus(){
		return $this->hasOne(StaffWorkingStatus::className(), ['id' => 'working_status']);
	}
	
	public function getStaffNationality(){
		return $this->hasOne(Country::className(), ['country_code' => 'nationality']);
	}
	
	public static function activeStaff(){
		return self::find()
		->select('staff.id, user.fullname as staff_name, user.id as user_id')
		->innerJoin('user', 'user.id = staff.user_id')
		->where(['staff.staff_active' => 1])->orderBy('user.fullname ASC')
		->all();
	}
	
	public static function activeStaffUserArray(){
		return ArrayHelper::map(self::activeStaff(), 'user_id', 'staff_name');
	}
	
	public static function activeStaffNotMe(){
		return self::find()
		->select('staff.id, user.fullname as staff_name, user.id as user_id')
		->innerJoin('user', 'user.id = staff.user_id')
		->where(['staff.staff_active' => 1])
		->andWhere(['<>', 'staff.id', Yii::$app->user->identity->staff->id])
		->all();
	}
	
	public function getUser(){
		return $this->hasOne(User::className(), ['id' => 'user_id']);
	}
	
	public function flashError(){
        if($this->getErrors()){
            foreach($this->getErrors() as $error){
                if($error){
                    foreach($error as $e){
                        Yii::$app->session->addFlash('error', $e);
                    }
                }
            }
        }

    }
	
	public function getTotalPublication(){
		return ErpdStats::countStaffPublication($this->id);
	}
	
	public function getTotalResearch(){
		return ErpdStats::countStaffResearch($this->id);
	}
	
	public function getTotalMembership(){
		return ErpdStats::countStaffMembership($this->id);
	}
	
	public function getTotalAward(){
		return ErpdStats::countStaffAward($this->id);
	}
	
	public function getTotalConsultation(){
		return ErpdStats::countStaffConsultation($this->id);
	}
	
	public function getTotalKtp(){
		return ErpdStats::countStaffKtp($this->id);
	}
	
	public function getListType(){
		return [
			0 => 'Administrative',
			1 => 'Academic'
		];
	}
	
	
	public function getTypeName(){
		$arr = $this->listType;
		return $arr[$this->is_academic];
	}
	
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

	//Bru buat
	public function getTeachLecture(){
		return $this->hasMany(LecLecturer::className(), ['staff_id' => 'id']);
	}

	public function getTeachLectureStr($br = "\n"){
		$list = $this->teachLecture;
		$str = '';
		if($list){
			$i = 1;
			foreach($list as $item){
				
				if($item->courseLecture){
					$d = $i == 1 ? '' : $br;
					$str .= $d.$item->courseLecture->lec_name;
				}
				
			$i++;
			}
		}
		return $str;
	}

	public function getTeachTutorial(){
		return $this->hasMany(TutorialTutor::className(), ['staff_id' => 'id']);
	}

	public function getTeachTutorialStr($br = "\n"){
		$list = $this->teachTutorial;
		$str = '';
		if($list){
			$i = 1;
			foreach($list as $item){
				
				if($item->tutorialLec){
					$d = $i == 1 ? '' : $br;
					$str .= $d.$item->tutorialLec->tutorial_name;
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
		$total = $countLecture + $countTutorial;
		return $total;
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
	
	public function getHqCountry(){
		return $this->hasOne(Country::className(), ['country_code' => 'hq_country']);
	}
	
	public function getHighAcademicQualification($br = "\n"){
		$country = '';
		if($this->hqCountry){
			$country = $this->hqCountry->country_name;
		}
		
		if($this->hq_year != '0000'){
			return $this->high_qualification. ',  ' .  
		$this->hq_specialization . ',  '  . 
		$this->hq_year . $br. $this->hq_institution . ', ' . 
		$country
		;
		}
		
	}
	
	
	public function getAcademicStaff(){
		return self::find()
		->joinWith('user')
		->where(['staff_active' => 1, 'is_academic' => 1, 'working_status' => 1])->orderBy('user.fullname ASC')->all();
	}
	
	public static function listAcademicStaffArray(){
		$list = self::find()
		->select('staff.id as staffid, user.fullname as fullname, staff.staff_title as stitle')
		->joinWith('user')
		->where(['staff_active' => 1, 'is_academic' => 1, 'faculty_id' => Yii::$app->params['faculty_id']])->orderBy('user.fullname ASC')->all();
		
		$array = [];
		
		foreach($list as $item){
			$array[$item->staffid] = $item->stitle . ' ' . $item->fullname;
		}
		
		return $array;
		
	}

}
