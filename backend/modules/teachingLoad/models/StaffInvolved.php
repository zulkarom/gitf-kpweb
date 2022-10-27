<?php

namespace backend\modules\teachingLoad\models;

use Yii;
use backend\models\Semester;
use backend\modules\teachingLoad\models\LecLecturer;
use backend\modules\teachingLoad\models\TutorialTutor;
use yii\helpers\Url;


/**
 * This is the model class for table "staff_inv".
 *
 * @property int $id
 * @property int $staff_id
 * @property int $semester_id
 * @property string $timetable_file
 */
class StaffInvolved extends \yii\db\ActiveRecord
{
   public $file_controller;
   public $timetable_instance;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tld_staff_inv';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['staff_id', 'semester_id'], 'required'],
			
            [['staff_id', 'semester_id', 'staff_check'], 'integer'],
			
            [['timetable_file'], 'string'],
			
			[['timetable_file'], 'required', 'on' => 'timetable_upload'],
            [['timetable_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf', 'maxSize' =>2000000],
            [['updated_at'], 'required', 'on' => 'timetable_delete'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'staff_id' => 'Staff ID',
            'semester_id' => 'Semester ID',
            'timetable_file' => 'Timetable File',
        ];
    }
	
	public function getProgressTimetable(){
		return Common::progress($this->prg_timetable);
	}
	
	public function afterSave($insert, $changedAttributes){
		parent::afterSave($insert, $changedAttributes);
		//kena cari ni offer apa yang terlibat
		$offers = $this->appointLetters;
		if($offers){
			foreach($offers as $offer){
				$modelOffer = $offer->courseOffered;
				if($modelOffer){
					$modelOffer->setOverallProgress();
					$modelOffer->save();
				}
				
			}
		}
		
	}
	
	public function getEditable(){
		$appoints = $this->appointLetters;
		if($appoints){
			foreach($appoints as $appoint){
				$status = $appoint->courseOffered->status;
				//echo $status.'*';
				if($status == 0 or $status == 20){
					return true;
				}
			}
		}
		//die();
		return false;
	}

    public function getStaff(){
        return $this->hasOne(Staff::className(), ['id' => 'staff_id']);
    }

    public function getSemester(){
        return $this->hasOne(Semester::className(), ['id' => 'semester_id']);
    }

    public function getLecturer(){
        return $this->hasOne(LecLecturer::className(), ['staff_id' => 'staff_id']);
    }
    
    public function getAppointLetters(){
        return $this->hasMany(AppointmentLetter::className(), ['inv_id' => 'id']);
    }

    public function getAppointLetterStr( $br = "\n"){
        
        $list = $this->appointLetters;
        $str = '';
        if($list){
            $i = 1;
            foreach($list as $item){
                $d = $i == 1 ? '' : $br;
                $str_link='<a href="'.Url::to(['/teaching-load/appointment-letter/pdf/', 'id' => $item->id]).'" target="_blank">'.$d.$item->courseOffered->course->codeCourseString.'</a>';
                $str .= $str_link;
                        $i++;     
            }
        }
        return $str ;
    }
}
