<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\StudentSemester */

$this->title = 'Add Semester: ' . $student->user->fullname;
$this->params['breadcrumbs'][] = ['label' => 'Student Semesters', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-semester-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
