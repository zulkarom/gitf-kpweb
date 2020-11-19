<?php

namespace backend\modules\teachingLoad\models;

use Yii;
use backend\modules\esiap\models\Course;
use backend\modules\staff\models\Staff;

/**
 * This is the model class for table "tld_course_offered".
 *
 * @property int $id
 * @property int $semester_id
 * @property int $course_id
 * @property string $created_at
 * @property int $created_by
 * @property int $coordinator
 */
class CourseOffered extends \yii\db\ActiveRecord
{
	public $courses;
	
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
            [['semester_id', 'course_id', 'created_at', 'created_by'], 'required'],
			
            [['semester_id', 'course_id', 'created_by', 'coordinator'], 'integer'],
			
            [['created_at', 'courses'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'semester_id' => 'Semester',
            'course_id' => 'Course',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'coordinator' => 'Coordinator',
        ];
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


    public function getlectures()
        {
            return $this->hasMany(CourseLecture::className(), ['offered_id' => 'id']);
        }

    public function getStaffName(){
        return $this->hasMany(Staff::className(), ['id' => 'coordinator']);
    }
}