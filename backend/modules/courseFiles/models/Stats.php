<?php

namespace backend\modules\courseFiles\models;

use backend\modules\teachingLoad\models\CourseOffered;

class Stats
{
    public $semester;
    public $total;

    public function __construct($semester)
    {
        $this->semester = $semester;
        $this->total = $this->total();
    }

    public function total(){
        $count = CourseOffered::find()->where(['semester_id' => $this->semester])->count();
        
        if($count > 0){
            return $count;
        }
        return 0;
    }


    public function countTotalCourseFileStatus($status){
        return CourseOffered::find()->where(['semester_id' => $this->semester, 'status' => $status])->count();
    }

    public function countTotalCourseFileAudited($audited){
        return CourseOffered::find()->where(['semester_id' => $this->semester, 'is_audited' => $audited])->count();
    }

    public function countTotalCourseInfo($status){
        return CourseOffered::find()
        ->joinWith('courseVersion v')
        ->where(['semester_id' => $this->semester, 'v.status' => $status])->count();
    }

    public function countTotalCourseFileSubmitted(){
        return CourseOffered::find()->where(['semester_id' => $this->semester, 'status' => [10,30,40,50]])->count();
    }

    public function countTotalCourseFileDraftOrReupdate(){
        return CourseOffered::find()->where(['semester_id' => $this->semester, 'status' => [0,20]])->count();
    }

    public function progressSubmission(){
        $p = $this->countTotalCourseFileSubmitted();
        $a = $this->total;
        if($a == 0){
            return 0;
        }
        $per = $p / $a;
        if($per > 0.9 && $per < 1){
            $per = 0.9;
        }
        return number_format($per,2);
    }

    public function progressAudit(){
        $p = $this->countTotalCourseFileAudited(1);
        $a = $this->total;
        if($a == 0){
            return 0;
        }
        $per = $p / $a;
        if($per > 0.9 && $per < 1){
            $per = 0.9;
        }
        return number_format($per,2);
    }

    public function progressCourseInfo(){
        $p = $this->countTotalCourseInfo(20);
        $a = $this->total;
        if($a == 0){
            return 0;
        }
        $per = $p / $a;
        if($per > 0.9 && $per < 1){
            $per = 0.9;
        }
        return number_format($per,2);
    }

    public function progressCourseFileVerification(){
        $p = $this->countTotalCourseFileStatus(50);
        $a = $this->total;
        if($a == 0){
            return 0;
        }
        $per = $p / $a;
        if($per > 0.9 && $per < 1){
            $per = 0.9;
        }
        return number_format($per,2);
    }

    



}
    