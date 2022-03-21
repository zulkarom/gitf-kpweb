<?php

namespace backend\modules\postgrad\models;

use Yii;
use yii\helpers\ArrayHelper;
use backend\modules\staff\models\Staff;
use backend\models\Semester;

/**
 * This is the model class for table "pd_student_stage".
 *
 * @property int $id
 * @property int $student_id
 * @property int $stage_id
 * @property string $stage_date
 * @property int $status
 */
class StudentStage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pg_student_stage';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['student_id', 'stage_id', 'semester_id', 'stage_date'], 'required'],
            [['student_id', 'stage_id', 'status', 'chairman_id', 'semester_id'], 'integer'],
            [['remark'], 'string'],
            [['stage_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'student_id' => 'Student',
            'chairman_id' => 'Chairman',
            'semester_id' => 'Semester',
            'semesterName' => 'Semester',
            'chairmanName' => 'Chairman',
            'stage_id' => 'Stage',
            'stage_date' => 'Stage Date',
            'status' => 'Status',
        ];
    }
    
    public function regSemesters($student){
        $list = StudentSemester::find()
        ->where(['student_id' => $student])
        ->all();
        $array = array();
        if($list){
            foreach($list as $s){
                $array[$s->semester_id] = $s->semester->longFormat();
            }
        }
        
        return $array;
    }
    
    public function getSemesterName(){
        return $this->semester->longFormat();
    }
    
    public function getStage(){
         return $this->hasOne(ResearchStage::className(), ['id' => 'stage_id']);
    }
    
    public function getSemester(){
        return $this->hasOne(Semester::className(), ['id' => 'semester_id']);
    }
    
    public function getExaminers(){
         return $this->hasMany(StageExaminer::className(), ['stage_id' => 'id']);
    }
    
    public function getStudent(){
        return $this->hasOne(Student::className(), ['id' => 'student_id']);
    }
    
    public function getChairman(){
        return $this->hasOne(Staff::className(), ['id' => 'chairman_id']);
    }
    
    public function getChairmanName(){
        return $this->chairman->user->fullname;
    }
    
    public function getStageListArray(){
        return ArrayHelper::map(ResearchStage::find()->all(), 'id', 'stage_name');
    }
    
    public function getStageName(){
        return $this->stage->stage_name;
    }
    
    public function getStudentName(){
        return $this->student->user->fullname;
    }

    
    public static function statusList(){
        return [
            10 => 'Permohonan',
            20 => 'Cadangan Penyelidikan Ditolak',
            30 => 'Pembentangan Semula', 
            90 => 'Lulus dengan Pindaan Kecil',
            100 => 'Lulus Tanpa Pindaan'
        ];
    }
    
    public static function statusText($status){
        $list = self::statusList();
        if(array_key_exists($status, $list)){
            return $list[$status];
        }
    }
    
    public function getStatusName(){
        return self::statusText($this->status);
    }
}
