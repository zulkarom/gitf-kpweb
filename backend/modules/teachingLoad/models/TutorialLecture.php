<?php

namespace backend\modules\teachingLoad\models;

use Yii;
use backend\modules\teachingLoad\models\TutorialTutor;
use backend\modules\teachingLoad\models\CourseLecture;
use backend\modules\courseFiles\models\TutorialCancelFile;
use backend\modules\courseFiles\models\TutorialReceiptFile;
use backend\modules\courseFiles\models\TutorialExemptFile;
use backend\modules\courseFiles\models\StudentTutorial;
/**
 * This is the model class for table "tld_tutorial_lec".
 *
 * @property int $id
 * @property int $lecture_id
 * @property string $tutorial_name
 * @property int $student_num
 * @property string $created_at
 * @property string $updated_at
 */
class TutorialLecture extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tld_tutorial_lec';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lecture_id', 'created_at', 'updated_at'], 'required'],
            [['lecture_id', 'student_num', 'prg_attend_complete'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['tutorial_name', 'lec_prefix'], 'string', 'max' => 50],
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
            'tutorial_name' => 'Tutorial Name',
            'student_num' => 'Student Num',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
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
	
	public function getProgressExemptClass(){
		return Common::progress($this->prg_class_exempt);
	}
	
	public function setProgressExemptClass($per){
		$this->prg_class_exempt = $per;
		$this->setOverallProgress();
	}
	
	public function getProgressCancelClass(){
		return Common::progress($this->prg_class_cancel);
	}
	
	public function setProgressCancelClass($per){
		$this->prg_class_cancel = $per;
		$this->setOverallProgress();
	}
	
	public function getProgressReceiptAssignment(){
		return Common::progress($this->prg_receipt_assess);
	}
	
	public function setProgressReceiptAssignment($per){
		$this->prg_receipt_assess = $per;
		$this->setOverallProgress();
	}
	
	public function getProgressStudentAttendance(){
		return Common::progress($this->prg_stu_attend);
	}
	
	public function setProgressStudentAttendance($per){
		$this->prg_stu_attend = $per;
		$this->setOverallProgress();
	}
	
	public function getProgressOverall(){
		$exempt = $this->prg_class_exempt;
		$receipt = $this->prg_receipt_assess;
		$cancel = $this->prg_class_cancel;
		$attend = $this->prg_stu_attend;
		
		$total = $exempt + $receipt + $cancel;
		$avg = $total / 4 * 100;
		$int = (int)$avg;
		$per = $int / 100;
		return $per;
	}
	
	public function getProgressOverallBar(){
		return Common::progress($this->prg_overall);
	}
	
	public function setOverallProgress(){
		$this->prg_overall = $this->progressOverall;
		/* if(!$this->save()){
			$this->flashError();
		} */
	}
	
	public function afterSave($insert, $changedAttributes){
		parent::afterSave($insert, $changedAttributes);
		$offer = $this->lecture->courseOffered;
		$offer->setOverallProgress();
		$offer->save();
		
	}


    public function getTutors()
    {
        return $this->hasMany(TutorialTutor::className(), ['tutorial_id' => 'id']);
    }

    //16.11.2020
    public function getLecture(){
        return $this->hasOne(CourseLecture::className(), ['id' => 'lecture_id']);
    }

    public function getTutorialCancelFiles(){
        return $this->hasMany(TutorialCancelFile::className(), ['tutorial_id' => 'id']);
    }

    public function getTutorialReceiptFiles(){
        return $this->hasMany(TutorialReceiptFile::className(), ['tutorial_id' => 'id']);
    }

    public function getTutorialExemptFiles(){
        return $this->hasMany(TutorialExemptFile::className(), ['tutorial_id' => 'id']);
    }
	
	public function getStudents()
    {
        return $this->hasMany(StudentTutorial::className(), ['tutorial_id' => 'id']);
    }
	
	public function getTutorialGroup(){
		return $this->lecturePrefix;
	}
	
	public function getLecturePrefix(){
		if($this->lec_prefix){
			$lec = $this->lec_prefix;
		}else{
			$lec = $this->lecture->lec_name;
		}
		return $lec;
	}
	
	public function getTutorialName(){
		return $this->lecturePrefix . $this->tutorial_name;
	}
}
