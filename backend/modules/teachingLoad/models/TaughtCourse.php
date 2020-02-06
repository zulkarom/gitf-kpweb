<?php

namespace backend\modules\teachingLoad\models;

use Yii;
use backend\modules\esiap\models\Course;

/**
 * This is the model class for table "tld_tgt_course".
 *
 * @property int $id
 * @property int $staff_id
 * @property int $course_id
 */
class TaughtCourse extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tld_tgt_course';
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
            'course_id' => 'Course',
        ];
    }
	
		public function getCourse(){
		return $this->hasOne(Course::className(), ['id' => 'course_id']);
	}
}
