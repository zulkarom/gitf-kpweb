<?php

namespace backend\modules\courseFiles\models;

use backend\modules\teachingLoad\models\CourseOffered;

class Stats
{
    public static function countTotalCourseFile($semester){
        return CourseOffered::find()->where(['semester_id' => $semester])->count();
    }

    public static function countTotalCourseFileStatus($semester, $status){
        return CourseOffered::find()->where(['semester_id' => $semester, 'status' => $status])->count();
    }

    public static function countTotalCourseFileAudited($semester, $audited){
        return CourseOffered::find()->where(['semester_id' => $semester, 'is_audited' => $audited])->count();
    }

    public static function countTotalCourseInfo($semester, $status){
        return CourseOffered::find()
        ->joinWith('courseVersion v')
        ->where(['semester_id' => $semester, 'v.status' => $status])->count();
    }



}
    