<?php

namespace backend\modules\teachingLoad\models;

use Yii;
use backend\modules\staff\models\Staff;
use backend\models\Semester;
use backend\modules\teachingLoad\models\LecLecturer;
use backend\modules\teachingLoad\models\TutorialTutor;

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
    
}