<?php

namespace backend\modules\teachingLoad\models;

use Yii;
use backend\modules\esiap\models\Course as CourseModel;

/**
 * This is the model class for table "tld_course_teach".
 *
 * @property int $id
 * @property int $staff_id
 * @property int $course_id
 */
class TeachCourse extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tld_teach_course';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['course_id'], 'required'],
            [['staff_id', 'course_id'], 'integer'],
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
            'course_id' => 'Course Name',
        ];
    }
	
	public function getCourse(){
		return $this->hasOne(CourseModel::className(), ['id' => 'course_id']);
	}
	
	public function getStaff(){
		return $this->hasOne(Staff::className(), ['id' => 'staff_id']);
	}
}
