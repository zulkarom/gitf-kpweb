<?php

namespace backend\modules\teachingLoad\models;

use Yii;
use backend\models\Semester;
use backend\modules\courseFiles\models\CoordinatorRubricsFile;
use backend\modules\courseFiles\models\CoordinatorMaterialFile;
use backend\modules\courseFiles\models\CoordinatorAssessmentMaterialFile;
use backend\modules\courseFiles\models\CoordinatorAssessmentScriptFile;
use backend\modules\courseFiles\models\CoordinatorSummativeAssessmentFile;
use backend\modules\courseFiles\models\CoordinatorAnswerScriptFile;
use backend\modules\courseFiles\models\CoordinatorAssessResultFile;
use backend\modules\courseFiles\models\CoordinatorEvaluationFile;
use backend\modules\courseFiles\models\CoordinatorResultCloFile;
use backend\modules\courseFiles\models\CoordinatorAnalysisCloFile;
use backend\modules\courseFiles\models\CoordinatorImproveFile;
use backend\modules\teachingLoad\models\CourseLecture;
use backend\modules\courseFiles\models\LectureExemptFile;
use backend\modules\courseFiles\models\LectureCancelFile;
use backend\modules\courseFiles\models\LectureReceiptFile;
use backend\modules\courseFiles\models\TutorialCancelFile;
use backend\modules\courseFiles\models\TutorialReceiptFile;
use backend\modules\courseFiles\models\TutorialExemptFile;
use backend\modules\courseFiles\models\Material;
use backend\modules\teachingLoad\models\AppointmentLetter;
use backend\modules\esiap\models\CourseVersion;
use backend\modules\esiap\models\CourseAssessment;
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
    public $sem;
    public $staff_id;
    public $offered_id;
	public $file_controller;
	
	public $scriptbest1_instance;
	public $scriptbest2_instance;
	public $scriptbest3_instance;
	public $scriptmod1_instance;
	public $scriptmod2_instance;
	public $scriptmod3_instance;
	public $scriptlow1_instance;
	public $scriptlow2_instance;
	public $scriptlow3_instance;

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
			
			[['course_version', 'material_version'], 'required', 'on' => 'coor'],
			
            [['semester_id', 'course_id', 'total_students', 'max_lec', 'max_tut', 'created_by', 'coordinator', 'course_version', 'material_version'], 'integer'],
			
            [['created_at', 'courses'], 'safe'],
			
            [['prefix_lec', 'prefix_tut'], 'string', 'max' => 225],
			
			 [['course_cqi'], 'string'],
			
			
			[['scriptbest1_file', 'scriptbest2_file', 'scriptbest3_file', 'scriptmod1_file', 'scriptmod2_file', 'scriptmod3_file', 'scriptlow1_file', 'scriptlow2_file', 'scriptlow3_file'], 'string'],
			
			[['scriptbest1_file'], 'required', 'on' => 'scriptbest1_upload'],
            [['scriptbest1_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf', 'maxSize' => 5000000],
            [['updated_at'], 'required', 'on' => 'scriptbest1_delete'],
			
			[['scriptbest2_file'], 'required', 'on' => 'scriptbest2_upload'],
            [['scriptbest2_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf', 'maxSize' => 5000000],
            [['updated_at'], 'required', 'on' => 'scriptbest2_delete'],
			
			[['scriptbest3_file'], 'required', 'on' => 'scriptbest3_upload'],
            [['scriptbest3_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf', 'maxSize' => 5000000],
            [['updated_at'], 'required', 'on' => 'scriptbest3_delete'],
			
			[['scriptmod1_file'], 'required', 'on' => 'scriptmod1_upload'],
            [['scriptmod1_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf', 'maxSize' => 5000000],
            [['updated_at'], 'required', 'on' => 'scriptmod1_delete'],
			
			[['scriptmod2_file'], 'required', 'on' => 'scriptmod2_upload'],
            [['scriptmod2_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf', 'maxSize' => 5000000],
            [['updated_at'], 'required', 'on' => 'scriptmod2_delete'],
			
			[['scriptmod3_file'], 'required', 'on' => 'scriptmod3_upload'],
            [['scriptmod3_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf', 'maxSize' => 5000000],
            [['updated_at'], 'required', 'on' => 'scriptmod3_delete'],
			
			[['scriptlow1_file'], 'required', 'on' => 'scriptlow1_upload'],
            [['scriptlow1_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf', 'maxSize' => 5000000],
            [['updated_at'], 'required', 'on' => 'scriptlow1_delete'],
			
			[['scriptlow2_file'], 'required', 'on' => 'scriptlow2_upload'],
            [['scriptlow2_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf', 'maxSize' => 5000000],
            [['updated_at'], 'required', 'on' => 'scriptlow2_delete'],
			
			[['scriptlow3_file'], 'required', 'on' => 'scriptlow3_upload'],
            [['scriptlow3_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf', 'maxSize' => 5000000],
            [['updated_at'], 'required', 'on' => 'scriptlow3_delete'],
			
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
			'material_version' => 'Material Group',
			'course_version' => 'Course Version',
			
			'scriptbest1_file' => 'Scriptbest1 File',
            'scriptbest2_file' => 'Scriptbest2 File',
            'scriptbest3_file' => 'Scriptbest3 File',
            'scriptmod1_file' => 'Scriptmod1 File',
            'scriptmod2_file' => 'Scriptmod2 File',
            'scriptmod3_file' => 'Scriptmod3 File',
            'scriptlow1_file' => 'Scriptlow1 File',
            'scriptlow2_file' => 'Scriptlow2 File',
            'scriptlow3_file' => 'Scriptlow3 File',
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

    public function getCourseVersion(){
        return $this->hasOne(CourseVersion::className(), ['id' => 'course_version']);
    }
	
	public function getMaterial(){
        return $this->hasOne(Material::className(), ['id' => 'material_version']);
    }

    public function listClo()
    {
		$array = array();
		if($this->courseVersion){
			if($this->courseVersion->clos){
				$list = $this->courseVersion->clos;
				if($list){
					$i =1;
					foreach ($list as $clo) {
						$array[] = $i;
						$i++;
					}
				}
			}
			
		}
        
        return $array;
    }

    public function getAssessment(){
        return $this->hasMany(CourseAssessment::className(), ['crs_version_id' => 'course_version']);
    }

    public function getCountLectures(){
        return CourseLecture::find()
        ->where(['offered_id' => $this->id])
        ->count();
    }
    
    public function getCountTutorials(){
        return TutorialLecture::find()
        ->joinWith(['lecture'])
        ->where(['offered_id' => $this->id])
        ->count();
    }

    public function getCountLecCancelFiles(){
        return LectureCancelFile::find()
        ->joinWith(['lecture'])
        ->where(['offered_id' => $this->id])
        ->count();
    }

    public function getCountLecExemptFiles(){
        return LectureExemptFile::find()
        ->joinWith(['lecture'])
        ->where(['offered_id' => $this->id])
        ->count();
    }

    public function getCountLecReceiptFiles(){
        return LectureReceiptFile::find()
        ->joinWith(['lecture'])
        ->where(['offered_id' => $this->id])
        ->count();
    }

    public function getCountTutCancelFiles(){
        return TutorialCancelFile::find()
        ->joinWith(['tutorial.lecture'])
        ->where(['offered_id' => $this->id])
        ->count();
    }

    public function getCountTutExemptFiles(){
        return TutorialExemptFile::find()
        ->joinWith(['tutorial.lecture'])
        ->where(['offered_id' => $this->id])
        ->count();
    }

     public function getCountTutReceiptFiles(){
        return TutorialReceiptFile::find()
        ->joinWith(['tutorial.lecture'])
        ->where(['offered_id' => $this->id])
        ->count();
    }

    public function getCountRubricFiles(){
        return CoordinatorRubricsFile::find()
        ->where(['offered_id' => $this->id])
        ->count();
    }

    public function getCountMaterialFiles(){
        return CoordinatorMaterialFile::find()
        ->where(['offered_id' => $this->id])
        ->count();
    }

    public function getCountAssessmentMaterialFiles(){
        return CoordinatorAssessmentMaterialFile::find()
        ->where(['offered_id' => $this->id])
        ->count();
    }

    public function getCountAssessmentScriptFiles(){
        return CoordinatorAssessmentScriptFile::find()
        ->where(['offered_id' => $this->id])
        ->count();
    }

    public function getCountSummativeAssessmentFiles(){
        return CoordinatorSummativeAssessmentFile::find()
        ->where(['offered_id' => $this->id])
        ->count();
    }

     public function  getCountAnswerScriptFiles(){
        return CoordinatorAnswerScriptFile::find()
        ->where(['offered_id' => $this->id])
        ->count();
    }

    public function getCountAssessResultFiles(){
        return CoordinatorAssessResultFile::find()
        ->where(['offered_id' => $this->id])
        ->count();
    }

    public function getCountEvaluationFiles(){
        return CoordinatorEvaluationFile::find()
        ->where(['offered_id' => $this->id])
        ->count();
    }

    public function getCountResultCloFiles(){
        return CoordinatorResultCloFile::find()
        ->where(['offered_id' => $this->id])
        ->count();
    }

    public function getCountAnalysisCloFiles(){
        return CoordinatorAnalysisCloFile::find()
        ->where(['offered_id' => $this->id])
        ->count();
    }

     public function getCountImproveFiles(){
        return CoordinatorImproveFile::find()
        ->where(['offered_id' => $this->id])
        ->count();
    }


    public function getCoor(){
        return $this->hasOne(Staff::className(), ['id' => 'coordinator']);
    }
    
    public function getSemester(){
        return $this->hasOne(Semester::className(), ['id' => 'semester_id']);
    }

    public function getCoordinatorRubricsFiles(){
        return $this->hasMany(CoordinatorRubricsFile::className(), ['offered_id' => 'id']);
    }

    public function getCoordinatorMaterialFiles(){
        return $this->hasMany(CoordinatorMaterialFile::className(), ['offered_id' => 'id']);
    }

     public function getCoordinatorAssessmentMaterialFiles(){
        return $this->hasMany(CoordinatorAssessmentMaterialFile::className(), ['offered_id' => 'id']);
    }

    public function getCoordinatorAssessmentScriptFiles(){
        return $this->hasMany(CoordinatorAssessmentScriptFile::className(), ['offered_id' => 'id']);
    }

     public function getCoordinatorSummativeAssessmentFiles(){
        return $this->hasMany(CoordinatorSummativeAssessmentFile::className(), ['offered_id' => 'id']);
    }

    public function getCoordinatorAnswerScriptFiles(){
        return $this->hasMany(CoordinatorAnswerScriptFile::className(), ['offered_id' => 'id']);
    }

    public function getCoordinatorAssessResultFiles(){
        return $this->hasMany(CoordinatorAssessResultFile::className(), ['offered_id' => 'id']);
    }

    public function getCoordinatorEvaluationFiles(){
        return $this->hasMany(CoordinatorEvaluationFile::className(), ['offered_id' => 'id']);
    }

    public function getCoordinatorResultCloFiles(){
        return $this->hasMany(CoordinatorResultCloFile::className(), ['offered_id' => 'id']);
    }
    
    public function getCoordinatorAnalysisCloFiles(){
        return $this->hasMany(CoordinatorAnalysisCloFile::className(), ['offered_id' => 'id']);
    }

    public function getCoordinatorImproveFiles(){
        return $this->hasMany(CoordinatorImproveFile::className(), ['offered_id' => 'id']);
    }

    public function getAppointmentLetter(){
        return $this->hasMany(AppointmentLetter::className(), ['offered_id' => 'id']);
    }    
}
