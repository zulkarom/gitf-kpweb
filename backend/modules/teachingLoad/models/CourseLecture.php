<?php

namespace backend\modules\teachingLoad\models;

use Yii;
use backend\modules\teachingLoad\models\TutorialLecture;
use backend\modules\teachingLoad\models\LecLecturer;
use backend\modules\teachingLoad\models\CourseOffered;
use backend\modules\courseFiles\models\LectureExemptFile;
use backend\modules\courseFiles\models\LectureCancelFile;
use backend\modules\courseFiles\models\LectureReceiptFile;
use backend\modules\courseFiles\models\StudentLecture;

/**
 * This is the model class for table "tld_course_lec".
 *
 * @property int $id
 * @property int $offered_id
 * @property string $lec_name
 * @property string $created_at
 * @property string $updated_at
 */
class CourseLecture extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tld_course_lec';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['offered_id', 'created_at', 'updated_at'], 'required'],
			
            [['offered_id', 'student_num', 'prg_stu_list'], 'integer'],
			
            [['prg_stu_attend', 'prg_attend_complete', 'prg_stu_assess', 'prg_class_cancel'], 'number'],
			
            [['created_at', 'updated_at'], 'safe'],
            [['lec_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'offered_id' => 'Offered ID',
            'lec_name' => 'Lec Name',
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
	
	public function getProgressStudentList(){
		return Common::progress($this->prg_stu_list);
	}
	
	public function setProgressStudentList($per){
		$this->prg_stu_list = $per;
		$this->setOverallProgress();
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
	
	public function getProgressStudentAssessment(){
		return Common::progress($this->prg_stu_assess);
	}
	
	public function setProgressStudentAssessment($per){
		$this->prg_stu_assess = $per;
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
		$list = $this->prg_stu_list;
		$assess = $this->prg_stu_assess;
		$attend = $this->prg_stu_attend;
		$total = $exempt + $receipt + $cancel + $list + $assess + $attend;
		$avg = $total / 6 * 100;
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

    public function getTutorials()
    {
        return $this->hasMany(TutorialLecture::className(), ['lecture_id' => 'id'])->orderBy('tutorial_name ASC');;
    }

    public function getLecturers()
    {
        return $this->hasMany(LecLecturer::className(), ['lecture_id' => 'id']);
    }
	
	public function getStudents()
    {
        return $this->hasMany(StudentLecture::className(), ['lecture_id' => 'id']);
    }
    
    public function getCourseOffered(){
        return $this->hasOne(CourseOffered::className(), ['id' => 'offered_id']);
    }
	
	public function getLectureExemptFiles(){
		return $this->hasMany(LectureExemptFile::className(), ['lecture_id' => 'id']);
	}

    public function getLectureCancelFiles(){
        return $this->hasMany(LectureCancelFile::className(), ['lecture_id' => 'id']);
    }

    public function getLectureReceiptFiles(){
        return $this->hasMany(LectureReceiptFile::className(), ['lecture_id' => 'id']);
    }


}
