<?php

namespace backend\modules\esiap\models;


use Yii;
use backend\models\Faculty;
use common\models\User;

/**
 * This is the model class for table "sp_course".
 *
 * @property int $id
 * @property string $course_code
 * @property string $course_name
 * @property string $course_name_bi
 * @property int $credit_hour
 * @property int $crs_type
 * @property int $crs_level
 * @property int $faculty
 * @property int $department
 * @property int $program
 * @property int $is_dummy
 * @property int $trash
 */
class Course extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sp_course';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			
			[['course_name', 'course_name_bi', 'course_code', 'credit_hour'], 'required', 'on' => 'update'],
			
			[['course_pic'], 'required', 'on' => 'coor'],
			
            [['is_active', 'course_pic', 'program_id', 'department_id', 'faculty_id'], 'integer'],
			
            [['course_name', 'course_name_bi'], 'string', 'max' => 100],
			
            [['course_code'], 'string', 'max' => 50],
			
			['course_code', 'unique', 'targetClass' => '\backend\modules\esiap\models\Course', 'message' => 'This course code has already been taken'],
			
        ];
    }

        /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'course_name' => 'Course Name (BM)',
			'course_name_bi' => 'Course Name (EN)',
            'course_code' => 'Course Code',
			'is_active' => 'Is Active',
			'program_id' => 'Program',
			'department_id' => 'Department'
        ];
    }
	
	
	public function getCoursePics(){
		return $this->hasMany(CoursePic::className(), ['course_id' => 'id']);
	}
	
	public function IAmCoursePic(){
		$pics = $this->coursePics;
		if($pics){
			foreach($pics as $pic){
				if($pic->staff_id == Yii::$app->user->identity->staff->id){
					return true;
				}
			}
		}
		return false;
	}
	
	public function getCodeAndCourse(){
		return $this->course_code . ' - ' . $this->course_name;
	}
	
	public function getCodeBrCourse(){
		return $this->course_code . '<br />' . $this->course_name;
	}
	
	public function allCoursesArray(){
		$result = self::find()->orderBy('course_name ASC')
		->where(['faculty_id' => 1, 'is_dummy' => 0])
		->all();
		$array[0] = 'Tiada / Nil';
		foreach($result as $row){
			$array[$row->id] = $row->course_name .' - '.$row->course_code;
		}
		return $array;
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
	
	public function getDefaultVersion(){
		return CourseVersion::findOne(['course_id' => $this->id, 'is_active' => 1]);

	}
	
	public function getFaculty(){
        return $this->hasOne(Faculty::className(), ['id' => 'faculty_id']);
    }


}
