<?php

namespace backend\modules\postgrad\models;

use Yii;
use backend\modules\esiap\models\Course;

/**
 * This is the model class for table "pg_semester_module".
 *
 * @property int $id
 * @property int $student_sem_id
 * @property int $module_id
 */
class SemesterModule extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pg_semester_module';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['student_sem_id', 'module_id'], 'required'],
            [['student_sem_id', 'module_id', 'result'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'student_sem_id' => 'Student Sem ID',
            'module_id' => 'Module',
        ];
    }
    
    public function getModule(){
         return $this->hasOne(Course::className(), ['id' => 'module_id']);
    }
    
    public function getModuleName(){
        return $this->module->codeAndCourse;
    }
    
    public function getStudentSemester(){
         return $this->hasOne(StudentSemester::className(), ['id' => 'student_sem_id']);
    }

    
    public function resultList(){
        return [
            10 => 'On Going',
            50 => 'Failed',
            100 => 'Passed'
        ];
    }
    public function getResultName(){
        $list = $this->resultList();
        if(array_key_exists($this->result, $list)){
            return $list[$this->result];
        }
    }

}
