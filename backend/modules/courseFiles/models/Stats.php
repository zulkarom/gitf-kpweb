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



}
    