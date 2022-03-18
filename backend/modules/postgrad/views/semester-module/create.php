<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\SemesterModule */



$this->title = 'Add Module: ' . $studentSemester->student->user->fullname;
$this->params['breadcrumbs'][] = ['label' => $studentSemester->student->user->fullname , 'url' => ['student/view', 'id' => $studentSemester->student_id]];
$this->params['breadcrumbs'][] = ['label' => 'Semester', 'url' => ['student-semester/view', 'id' => $studentSemester->id]];
$this->params['breadcrumbs'][] = 'Add Module';


?>
<div class="semester-module-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
