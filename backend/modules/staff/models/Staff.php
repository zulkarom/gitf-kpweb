<?php

namespace backend\modules\staff\models;

use Yii;
use common\models\User;
use yii\helpers\ArrayHelper;

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
 * @property string $user_token
 * @property int $user_token_at
 */
class Staff extends \yii\db\ActiveRecord
{
	public $staff_name;
	public $email;
	
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
			
			[['user_id'], 'required', 'on' => 'reload'],
			
			[['email'], 'email'],
			
			['staff_no', 'unique', 'targetClass' => '\backend\modules\staff\models\Staff', 'message' => 'This staff no has already been taken'],
			
			//['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email has already been taken'],
			
			
            [['user_id', 'is_academic', 'position_id', 'position_status', 'working_status',  'staff_department', 'publish', 'staff_active'], 'integer'],
            [['leave_start', 'leave_end', 'staff_dob', 'date_begin_umk', 'date_begin_service'], 'safe'],
			
            [['leave_note', 'staff_interest'], 'string'],
			
            [['staff_no'], 'string', 'max' => 10],
            [['staff_note', 'personal_email', 'ofis_location'], 'string', 'max' => 100],
            [['staff_title', 'officephone', 'handphone1', 'handphone2'], 'string', 'max' => 20],
			
            [['staff_edu', 'staff_expertise', 'staff_cv'], 'string', 'max' => 300],
			
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
            'staff_title' => 'Staff Title',
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
        ];
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
	
	public function getWorkingStatus(){
		return $this->hasOne(StaffWorkingStatus::className(), ['id' => 'working_status']);
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

}
