<?php

namespace backend\modules\teachingLoad\models;

use Yii;
use backend\modules\teachingLoad\models\CourseLecture;
use backend\modules\staff\models\Staff;

/**
 * This is the model class for table "lec_lecturer".
 *
 * @property int $id
 * @property int $lecture_id
 * @property int $staff_id
 */
class LecLecturer extends \yii\db\ActiveRecord
{
	public $course_id;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tld_lec_lecturer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lecture_id'], 'required'],
            [['lecture_id', 'staff_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lecture_id' => 'Lecture ID',
            'staff_id' => 'Staff ID',
        ];
    }

    public function getStaff(){
        return $this->hasOne(Staff::className(), ['id' => 'staff_id']);
    }

     public function getStaffInvolved(){
        return $this->hasOne(StaffInvolved::className(), ['staff_id' => 'staff_id']);
    }

    public function getCourseLecture(){
        return $this->hasOne(CourseLecture::className(), ['id' => 'lecture_id']);
    }
	
}
