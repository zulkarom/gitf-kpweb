<?php

namespace backend\modules\courseFiles\models;

use Yii;
use backend\modules\students\models\Student;

/**
 * This is the model class for table "cf_student_lec".
 *
 * @property int $id
 * @property int $lecture_id
 * @property string $matric_no
 * @property string $assess_result
 */
class StudentLecture extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cf_student_lec';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lecture_id', 'matric_no'], 'required'],
            [['lecture_id'], 'integer'],
            [['assess_result'], 'string'],
            [['matric_no'], 'string', 'max' => 20],
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
            'matric_no' => 'Matric No',
            'assess_result' => 'Assess Result',
        ];
    }

    public function getStudent(){
        return $this->hasOne(Student::className(), ['matric_no' => 'matric_no']);
    } 
}
