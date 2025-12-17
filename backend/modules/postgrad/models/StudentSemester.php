<?php

namespace backend\modules\postgrad\models;

use Yii;
use backend\models\Semester;

/**
 * This is the model class for table "pg_student_reg".
 *
 * @property int $id
 * @property int $semester_id
 * @property string $date_register
 * @property int $status
 */
class StudentSemester extends StudentRegister
{
}
