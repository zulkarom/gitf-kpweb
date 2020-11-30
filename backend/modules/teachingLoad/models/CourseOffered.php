<?php

namespace backend\modules\teachingLoad\models;

use Yii;
use backend\modules\esiap\models\Course;
use backend\modules\staff\models\Staff;
use backend\models\Semester;


/**
 * This is the model class for table "tld_course_offered".
 *
 * @property int $id
 * @property int $semester_id
 * @property int $course_id
 * @property int $total_students
 * @property int $max_lec
 * @property string $prefix_lec
 * @property int $max_tut
 * @property string $prefix_tut
 * @property string $created_at
 * @property int $created_by
 * @property int $coordinator
 */
class CourseOffered extends \yii\db\ActiveRecord
{
    public $courses;
    public $semester;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tld_course_offered';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['semester_id', 'course_id','created_at', 'created_by'], 'required'],
            [['semester_id', 'course_id', 'total_students', 'max_lec', 'max_tut', 'created_by', 'coordinator'], 'integer'],
            [['created_at', 'courses'], 'safe'],
            [['prefix_lec', 'prefix_tut'], 'string', 'max' => 225],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'semester_id' => 'Semester ID',
            'course_id' => 'Course ID',
            'total_students' => 'Total Students',
            'max_lec' => 'Max Lec',
            'prefix_lec' => 'Prefix Lec',
            'max_tut' => 'Max Tut',
            'prefix_tut' => 'Prefix Tut',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'coordinator' => 'Coordinator',
        ];
    }

    public function getOffer($semester){
        return CourseOffered::find()
            ->where(['course_id' => $this->id, 'semester_id' => $semester ])
            ->one(); 
    }
    
    public function getCourse(){
         return $this->hasOne(Course::className(), ['id' => 'course_id']);
    }
    
    public function flashError(){
        if($this->getErrors()){
            foreach($this->getErrors() as $error){
                if($error){
                    foreach($error as $e){
                        Yii::$app->session->addFlash('error', $e);
                    }
                }
            }
        }

    }
    public function getLectures()
        {
            return $this->hasMany(CourseLecture::className(), ['offered_id' => 'id']);
        }

    public function getTotalStudents(){
        $list1 = $this->lectures;
        $totalStudent = 0;
        if($list1){
            $i = 1;
            foreach($list1 as $item){
                $totalStudent = $item->student_num+$totalStudent;
                $i++;
            }
        }
        return $totalStudent;

    }

    public function getCoor(){
        return $this->hasOne(Staff::className(), ['id' => 'coordinator']);
    }
    
    public function getSemester(){
        return $this->hasOne(Semester::className(), ['id' => 'semester_id']);
    }
}
