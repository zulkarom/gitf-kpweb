<?php

namespace backend\modules\teachingLoad\models;

use Yii;
use backend\modules\teachingLoad\models\StaffInvolved;
use backend\modules\teachingLoad\models\CourseOffered;
use backend\models\Semester;
use backend\modules\teachingLoad\models\LecLecturer;
use backend\modules\teachingLoad\models\TutorialTutor;

/**
 * This is the model class for table "tld_appoint_letter".
 *
 * @property int $id
 * @property int $inv_id
 * @property int $offered_id
 * @property string $ref_no
 * @property string $date_appoint
 */
class AppointmentLetter extends \yii\db\ActiveRecord
{
	public $steva_instance;
	public $manual_instance;
	public $file_controller;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tld_appoint_letter';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['inv_id', 'offered_id'], 'required'],
            [['inv_id', 'offered_id', 'status', 'tutorial_only'], 'integer'],
            [['date_appoint'], 'safe'],
            [['ref_no'], 'string', 'max' => 225],
			
			[['steva_file'], 'required', 'on' => 'steva_upload'],
            [['steva_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf', 'maxSize' => 2000000],
            [['updated_at'], 'required', 'on' => 'steva_delete'],
            
            [['manual_file'], 'required', 'on' => 'manual_upload'],
            [['manual_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf', 'maxSize' => 2000000],
            [['updated_at'], 'required', 'on' => 'manual_delete'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'inv_id' => 'Inv ID',
            'offered_id' => 'Offered ID',
            'ref_no' => 'Ref No',
            'date_appoint' => 'Date Appoint',
			'steva_file' => 'Student Evaluation',
            'manual_file' => 'Upload Appointment Letter'
        ];
    }

    public function status(){
        return [
            1 => 'Draft',
            0 => 'Draft',
            10 =>'Approved'
        ];
    }

    public function getStatusText(){
        $arr = $this->status();
        if(array_key_exists($this->status, $this->status())){
             return $arr[$this->status];
        }
       
    }
	
	public function setProgressAppointment(){
		$letter = 0;
		if($this->manual_file){
		    $letter = 1;
		}else if($this->status == 10){
			$letter = 1;
		}
		$steva = 0;
		if($this->steva_file){
			$steva = 1;
		}else if($this->tutorial_only){
		    $steva = 1;
		}
		$avg = ($letter + $steva) / 2;
		$this->prg_appoint_letter = number_format($avg,2);
	}
	
	public function afterSave($insert, $changedAttributes){
		parent::afterSave($insert, $changedAttributes);
		$offer = $this->courseOffered;
		$offer->setOverallProgress();
		$offer->save();
		
	}
	
	public function getProgressAppointmentBar(){
		return Common::progress($this->prg_appoint_letter);
	}
	
	public function getStatusLabel(){
		if($this->status == 10){
			$color = 'success';
		}else{
			$color = 'warning';
		}
		return '<span class="label label-'.$color.'" >' . strtoupper($this->statusText) . '</span>';
	}

    public function getStaffInvolved(){
        return $this->hasOne(StaffInvolved::className(), ['id' => 'inv_id']);
    }

    public function getCourseOffered(){
        return $this->hasOne(CourseOffered::className(), ['id' => 'offered_id']);
    }

    

    public function getAppointed(){
        $coordinator = $this->courseOffered->coordinator;
        if($coordinator ==  $this->staffInvolved->staff_id){
            $type = "Penyelaras & Pengajar";
        }else{
            $type = "Pengajar";
        }
        return $type;
    }

    public function getCountLecturesByStaff(){
        $staff_id = $this->staffInvolved->staff_id;
        return LecLecturer::find()
        ->joinWith('courseLecture.courseOffered')
        ->where(['staff_id' => $staff_id, 'offered_id' => $this->offered_id])
        ->count();
    }

    public function getCountTutorialsByStaff(){
        $staff_id = $this->staffInvolved->staff_id;
        return TutorialTutor::find()
        ->joinWith('tutorialLec.lecture.courseOffered')
        ->where(['staff_id' => $staff_id, 'offered_id' => $this->offered_id])
        ->count();
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
