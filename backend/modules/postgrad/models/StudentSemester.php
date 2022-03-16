<?php

namespace backend\modules\postgrad\models;

use Yii;
use backend\models\Semester;

/**
 * This is the model class for table "pg_student_sem".
 *
 * @property int $id
 * @property int $semester_id
 * @property string $date_register
 * @property int $status
 */
class StudentSemester extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pg_student_sem';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['student_id', 'semester_id', 'status'], 'required'],
            [['semester_id', 'status', 'student_id'], 'integer'],
            ['fee_amount', 'number'],
            [['date_register', 'fee_paid_at'], 'safe'],
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
            'date_register' => 'Date Register',
            'status' => 'Status',
            'free_paid_at' => 'Payment Date'
        ];
    }
    
    public function statusList(){
        return [
            10 => 'Active',
            20 => 'Postpone',
            100 => 'Complete'
        ];
    }
    
    public function statusText(){
        $list = $this->statusList();
        if(array_key_exists($this->status, $list)){
            return $list[$this->status];
        }
    }
    
    public function getSemester(){
         return $this->hasOne(Semester::className(), ['id' => 'semester_id']);
    }
    
    public function getStudent(){
        return $this->hasOne(Student::className(), ['id' => 'student_id']);
    }
    
    
}
