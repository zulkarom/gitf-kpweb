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
            [['inv_id', 'offered_id', 'status'], 'integer'],
            [['date_appoint'], 'safe'],
            [['ref_no'], 'string', 'max' => 225],
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
        ];
    }

    public function status(){
        return [
            1 => 'Draft',
            10 =>'Approve'
        ];
    }

    public function getStatusText(){
        $arr = $this->status();
        if(array_key_exists($this->status, $this->status())){
             return $arr[$this->status];
        }
       
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
            $type = "Coordinator & Lecturer";
        }else{
            $type = "Lecturer";
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

}
