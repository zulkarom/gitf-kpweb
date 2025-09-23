<?php

namespace backend\modules\apprentice\models;

use Yii;

/**
 * This is the model class for table "apr_apprentice".
 *
 * @property int $id
 * @property int $student_id
 * @property int $semester_id
 * @property int $status
 * @property string $program_code
 * @property string $course_code
 * @property int $created_at
 * @property int $updated_at
 */
class Apprentice extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'apr_apprentice';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['student_id', 'semester_id', 'course_code'], 'required'],
            [['student_id', 'semester_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['program_code', 'course_code'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'student_id' => 'Student ID',
            'semester_id' => 'Semester ID',
            'status' => 'Status',
            'program_code' => 'Program Code',
            'course_code' => 'Course Code',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
