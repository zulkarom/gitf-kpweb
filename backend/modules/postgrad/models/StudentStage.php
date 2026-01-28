<?php

namespace backend\modules\postgrad\models;

use Yii;
use yii\helpers\ArrayHelper;
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
            [['student_id', 'stage_id', 'semester_id'], 'required'],
            [['student_id', 'stage_id', 'status', 'semester_id'], 'integer'],
            [['remark'], 'string'],
            [['stage_date', 'stage_time'], 'safe'],
            [['thesis_title'], 'string', 'max' => 500],
            [['location'], 'string', 'max' => 255],
            [['meeting_link'], 'string', 'max' => 500],
            [['meeting_mode'], 'in', 'range' => array_keys(self::meetingModeList())],
        ];
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            if (empty($this->stage_date) && !empty($this->semester_id)) {
                $semester = Semester::findOne((int)$this->semester_id);
                if ($semester) {
                    $id = (string)$semester->id;
                    $year1 = substr($id, 0, 4);
                    $year2 = substr($id, 4, 4);
                    $session = substr($id, 8, 1);

                    if ($session == '1') {
                        // September of year1
                        $this->stage_date = $year1 . '-09-01';
                    } elseif ($session == '2') {
                        // February of year2
                        $this->stage_date = $year2 . '-02-01';
                    }
                }
            }

            return true;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'student_id' => 'Student',
            'semester_id' => 'Semester',
            'semesterName' => 'Semester',
            'stage_id' => 'Stage',
            'stage_date' => 'Stage Date',
            'stage_time' => 'Stage Time',
            'thesis_title' => 'Thesis Title',
            'location' => 'Location',
            'meeting_link' => 'Meeting Link',
            'meeting_mode' => 'Meeting Mode',
            'status' => 'Status',
        ];
    }

    public static function meetingModeList()
    {
        return [
            'physical' => 'Physical',
            'online' => 'Online',
        ];
    }
    
    public function regSemesters($student){
        $array = [];
        $list = Semester::listSemesterArray();
        if ($list) {
            $array = $list;
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
    
    public function getStageListArray(){
        $stages = ResearchStage::find()->orderBy(['id' => SORT_ASC])->all();
        $list = [];
        foreach ($stages as $s) {
            $abbr = (string)$s->stage_abbr;
            $en = (string)$s->stage_name_en;
            $label = $abbr;
            if ($en !== '') {
                $label = $abbr !== '' ? ($abbr . ' - ' . $en) : $en;
            }
            $list[$s->id] = $label;
        }
        return $list;
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
