<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\SemesterModule */

$this->title = 'Update Module: ' . $model->studentSemester->student->user->fullname;
$this->params['breadcrumbs'][] = ['label' => $model->studentSemester->student->user->fullname , 'url' => ['student/view', 'id' => $model->studentSemester->student_id]];
$this->params['breadcrumbs'][] = ['label' => 'Semester', 'url' => ['student-register/view', 'id' => $model->student_sem_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="semester-module-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
