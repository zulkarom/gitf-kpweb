<?php

namespace backend\modules\postgrad\controllers;

use Yii;
use backend\modules\postgrad\models\StudentSemester;
use backend\modules\postgrad\models\StudentSemesterSearch;

/**
 * StudentSemesterController implements the CRUD actions for StudentSemester model.
 */
class StudentSemesterController extends StudentRegisterController
{
    public function getViewPath()
    {
        return dirname(__DIR__) . '/views/student-register';
    }
}
