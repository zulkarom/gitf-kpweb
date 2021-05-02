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
use backend\modules\courseFiles\models\CoordinatorResultFinalFile;
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
	public $option_review;
	public $option_course;
	
	public $scriptbest1_instance;
	public $scriptbest2_instance;
	public $scriptbest3_instance;
	public $scriptmod1_instance;
	public $scriptmod2_instance;
	public $scriptmod3_instance;
	public $scriptlow1_instance;
	public $scriptlow2_instance;
	public $scriptlow3_instance;
	
	public $auditor_instance;
	public $verified_instance;

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
			
			[['option_course', 'option_review'], 'required', 'on' => 'audit'],
			
            [['semester_id', 'course_id', 'total_students', 'max_lec', 'max_tut', 'created_by', 'coordinator', 'course_version', 'material_version', 'prg_crs_ver', 'prg_material', 'na_cont_rubrics', 'na_script_final', 'coor_access', 'option_course', 'option_review'], 'integer'],
			
            [['created_at', 'courses'], 'safe'],
			
			[['prg_overall', 'prg_cont_rubrics'], 'number'],
			
            [['prefix_lec', 'prefix_tut'], 'string', 'max' => 225],
			
			 [['course_cqi'], 'string'],
			
			
			[['scriptbest1_file', 'scriptbest2_file', 'scriptbest3_file', 'scriptmod1_file', 'scriptmod2_file', 'scriptmod3_file', 'scriptlow1_file', 'scriptlow2_file', 'scriptlow3_file'], 'string'],
			
			[['scriptbest1_file'], 'required', 'on' => 'scriptbest1_upload'],
            [['scriptbest1_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf', 'maxSize' => 7000000],
            [['updated_at'], 'required', 'on' => 'scriptbest1_delete'],
			
			[['scriptbest2_file'], 'required', 'on' => 'scriptbest2_upload'],
            [['scriptbest2_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf', 'maxSize' => 7000000],
            [['updated_at'], 'required', 'on' => 'scriptbest2_delete'],
			
			[['scriptbest3_file'], 'required', 'on' => 'scriptbest3_upload'],
            [['scriptbest3_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf', 'maxSize' => 7000000],
            [['updated_at'], 'required', 'on' => 'scriptbest3_delete'],
			
			[['scriptmod1_file'], 'required', 'on' => 'scriptmod1_upload'],
            [['scriptmod1_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf', 'maxSize' => 7000000],
            [['updated_at'], 'required', 'on' => 'scriptmod1_delete'],
			
			[['scriptmod2_file'], 'required', 'on' => 'scriptmod2_upload'],
            [['scriptmod2_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf', 'maxSize' => 7000000],
            [['updated_at'], 'required', 'on' => 'scriptmod2_delete'],
			
			[['scriptmod3_file'], 'required', 'on' => 'scriptmod3_upload'],
            [['scriptmod3_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf', 'maxSize' => 7000000],
            [['updated_at'], 'required', 'on' => 'scriptmod3_delete'],
			
			[['scriptlow1_file'], 'required', 'on' => 'scriptlow1_upload'],
            [['scriptlow1_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf', 'maxSize' => 7000000],
            [['updated_at'], 'required', 'on' => 'scriptlow1_delete'],
			
			[['scriptlow2_file'], 'required', 'on' => 'scriptlow2_upload'],
            [['scriptlow2_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf', 'maxSize' => 7000000],
            [['updated_at'], 'required', 'on' => 'scriptlow2_delete'],
			
			[['scriptlow3_file'], 'required', 'on' => 'scriptlow3_upload'],
            [['scriptlow3_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf', 'maxSize' => 7000000],
            [['updated_at'], 'required', 'on' => 'scriptlow3_delete'],
			
			[['auditor_file'], 'required', 'on' => 'auditor_upload'],
            [['auditor_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf', 'maxSize' => 2000000],
            [['updated_at'], 'required', 'on' => 'auditor_delete'],
			
			[['verified_file'], 'required', 'on' => 'verified_upload'],
            [['verified_instance'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf', 'maxSize' => 2000000],
            [['updated_at'], 'required', 'on' => 'verified_delete'],
			
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
			'statusName' => 'Status',
			'auditor_file' => 'Auditor\'s Report',
        ];
    }
	
	public function getStatusName(){
		if($this->status == 0){
			return '<span class="label label-warning">DRAFT</span>';
		}else if($this->status == 10){
			return '<span class="label label-info">SUBMIT</span>';
		}else if($this->status == 20){
			return '<span class="label label-warning">REUPDATE</span>';
		}else if($this->status == 30){
			return '<span class="label label-info">COMPLETE</span>';
		}else if($this->status == 40){
			return '<span class="label label-info">RESUBMIT</span>';
		}else if($this->status == 50){
			return '<span class="label label-success">VERIFIED</span>';
		}else{
			return '';
		}
	}
	
	public function getProgressOverallBar(){
		return Common::progress($this->prg_overall);
		
	}
	
	public function setOverallProgress(){
		//start with lectures
		$count = 0;
		$total = 0;
		$avg = 0;
		if($this->lectures){
			foreach($this->lectures as $lecture){
				$total += $lecture->prg_overall;
				$count++;
				if($lecture->tutorials){
				  foreach ($lecture->tutorials as $tutorial) {
					  $total += $tutorial->prg_overall;
					  $count++;
				  }
				}
			}
		}
		//then appoint letter
		if($this->appointmentLetter){
			foreach($this->appointmentLetter as $app){
				if($app->staffInvolved){
					$count++;
					$total += $app->prg_appoint_letter;
					$count++;
					$total += $app->staffInvolved->prg_timetable;
				}
			}
			
		}
		
		$total += $this->prg_coordinator;
		$count++;
		
		if($count > 0){
			$avg = $total / $count;
			$avg = Common::withoutRounding($total / $count, 2);
		}
		//$avg round($avg, 2 ,PHP_ROUND_HALF_DOWN);
		$this->prg_overall = $avg;
	}
	
	
	
	public function setProgressCoordinator(){
		$p1 = $this->prg_crs_ver; //1
		$p2 = $this->prg_material; //2
		$p3 = $this->prg_cont_rubrics ; //3
		$p4 = $this->prg_sum_assess;
		$p5 = $this->prg_cont_material;
		$p6 = $this->prg_result_final;
		$p7 = $this->prg_cont_script;
		$p8 = $this->prg_sum_script;
		$p9 = $this->prg_cqi;
		$avg = ($p1 + $p2 + $p3 + $p4 + $p5 + $p6 + $p7 + $p8 + $p9)/9;
		$this->prg_coordinator = Common::withoutRounding($avg,2);
		$this->setOverallProgress();
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
	
	public function setProgressCourseVersion($val){
		$this->prg_crs_ver = $val;
		$this->setProgressCoordinator();
	}
	
	public function getProgressCourseVersionBar(){
		return Common::progress($this->prg_crs_ver);
	}
	
	public function setProgressMaterial($val){
		$this->prg_material = $val;
		$this->setProgressCoordinator();
	}
	
	public function getProgressMaterialBar(){
		return Common::progress($this->prg_material);
	}
	
	public function setProgressContRubrics($val){
		$this->prg_cont_rubrics = $val;
		$this->setProgressCoordinator();
	}
	
	public function getProgressContRubricsBar(){
		return Common::progress($this->prg_cont_rubrics);
		
	}
	
	public function setProgressSumAssess($val){
		$this->prg_sum_assess = $val;
		$this->setProgressCoordinator();
	}
	
	public function getProgressSumAssessBar(){
		return Common::progress($this->prg_sum_assess);
		
	}
	
	public function setProgressContMaterial($val){
		$this->prg_cont_material = $val;
		$this->setProgressCoordinator();
	}
	
	public function getProgressContMaterialBar(){
		return Common::progress($this->prg_cont_material);
	}
	
	public function setProgressResultFinal($val){
		$this->prg_result_final = $val;
		$this->setProgressCoordinator();
	}
	
	public function getProgressResultFinalBar(){
		return Common::progress($this->prg_result_final);
	}
	
	public function setProgressContScript($val){
		$this->prg_cont_script = $val;
		$this->setProgressCoordinator();
	}
	
	public function getProgressContScriptBar(){
		return Common::progress($this->prg_cont_script);
	}
	
	public function setProgressSumScript(){
		if($this->na_script_final == 1){
			$this->prg_sum_script = 1;
		}else{
			$per = $this->countScripts / 9;
			$per = number_format($per, 2);
			$this->prg_sum_script = $per;
		}
		$this->setProgressCoordinator();
	}
	
	public function getCountScripts(){
		$val = 0;
		if($this->scriptbest1_file){
			$val++;
		}
		if($this->scriptbest2_file){
			$val++;
		}
		if($this->scriptbest3_file){
			$val++;
		}
		if($this->scriptmod1_file){
			$val++;
		}
		if($this->scriptmod2_file){
			$val++;
		}
		if($this->scriptmod3_file){
			$val++;
		}
		if($this->scriptlow1_file){
			$val++;
		}
		if($this->scriptlow2_file){
			$val++;
		}
		if($this->scriptlow3_file){
			$val++;
		}
		
		return $val;
	}
	
	public function getProgressSumScriptBar(){
		return Common::progress($this->prg_sum_script);
	}
	
	public function setProgressCqi($val){
		$this->prg_cqi = $val;
		$this->setProgressCoordinator();
	}
	
	public function getProgressCqiBar(){
		return Common::progress($this->prg_cqi);
	}
	
	
	
	public function getProgressCoordinatorBar(){
		return Common::progress($this->prg_coordinator);
	}
	
    public function getLectures()
	{
		return $this->hasMany(CourseLecture::className(), ['offered_id' => 'id'])->orderBy('lec_name ASC');
	}
	
	public function getCourseLectures()
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
	
	//return array
	public function getCloSummary(){
		$array = array();
		if($this->listClo()){
			  foreach ($this->listClo() as $clo) {
				$str_total = 'total_clo'. $clo;
				$$str_total = 0;
				$str_count = 'count_clo'. $clo;
				$$str_count = 0;
			  }
		foreach($this->lectures as $lecture){
			$arr = json_decode($lecture->clo_achieve);
			/* if(!is_array($arr)){
				$arr = [];
			} */
			$counted = true;
			if($arr == null){
				$arr = [];
				$counted = false;
			}
			$x = 0;
				$total = 0;
				$count = 0;
				foreach ($this->listClo() as $clo) {
					$str_total = 'total_clo'. $clo;
					$str_count = 'count_clo'. $clo;
					$val = 0;
					if($counted){$$str_count++;}
					if(array_key_exists($x, $arr)){
						$val = $arr[$x];
					}
					$$str_total += $val;
					$x++;
				}
		}
		
		$p =0;
		
		foreach ($this->listClo() as $clo) {
			$str_total = 'total_clo'. $clo;
			$str_count = 'count_clo'. $clo;
			if($$str_count == 0){
				$avg = 0;
			}else{
				$avg = $$str_total / $$str_count;
			}
					
			$array[] = number_format($avg,2);
		$p++;
		}
		
		}
		return $array;
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
	
	 public function getCountResultFinalFiles(){
        return CoordinatorResultFinalFile::find()
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
	
	public function getAuditor(){
        return $this->hasOne(Staff::className(), ['id' => 'auditor_staff_id']);
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
	
	 public function getCoordinatorResultFinalFiles(){
        return $this->hasMany(CoordinatorResultFinalFile::className(), ['offered_id' => 'id']);
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
