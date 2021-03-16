<?php

namespace backend\modules\courseFiles\models;

use Yii;
use backend\modules\students\models\Student;
use backend\modules\teachingLoad\models\TutorialLecture;

/**
 * This is the model class for table "cf_student_lec".
 *
 * @property int $id
 * @property int $tutorial_id
 * @property string $matric_no
 * @property string $assess_result
 */
class StudentTutorial extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cf_student_tut';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tutorial_id', 'matric_no'], 'required'],
            [['tutorial_id', 'stud_check'], 'integer'],
            [['attendance_check'], 'string'],
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
            'tutorial_id' => 'Lecture ID',
            'matric_no' => 'Matric No',
            'assess_result' => 'Assess Result',
        ];
    }

    public function getStudent(){
        return $this->hasOne(Student::className(), ['matric_no' => 'matric_no']);
    }
	
	public function getMatricAndName(){
		return $this->matric_no . ' ' . $this->student->st_name;
	}


    public function getTutorial(){
        return $this->hasOne(TutorialLecture::className(), ['id' => 'tutorial_id']);
    }
}
