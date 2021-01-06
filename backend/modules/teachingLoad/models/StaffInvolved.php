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

    public function getStaff(){
        return $this->hasOne(Staff::className(), ['id' => 'staff_id']);
    }

    public function getSemester(){
        return $this->hasOne(Semester::className(), ['id' => 'semester_id']);
    }

    public function getLecturer(){
        return $this->hasOne(LecLecture::className(), ['staff_id' => 'staff_id']);
    }
    
    public function getAppointLetter(){
        return $this->hasMany(AppointmentLetter::className(), ['inv_id' => 'id']);
    }

    public function getAppointLetterStr( $br = "\n"){
        
        $list = $this->appointLetter;
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
