<?php

namespace backend\modules\teachingLoad\models;

use Yii;

/**
 * This is the model class for table "tld_out_course".
 *
 * @property int $id
 * @property int $staff_id
 * @property string $course_name
 */
class OutCourse extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tld_out_course';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           // [['course_name'], 'required'],
            [['staff_id'], 'integer'],
            [['course_name'], 'string', 'max' => 200],
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
            'course_name' => 'Course Name',
        ];
    }
}
