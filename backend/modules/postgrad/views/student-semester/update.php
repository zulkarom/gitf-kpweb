<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\StudentSemester */
$name = $model->student->user->fullname;
$this->title = 'Update Semester: ' . $name;
$this->params['breadcrumbs'][] = ['label' => 'Students', 'url' => ['student/index']];
$this->params['breadcrumbs'][] = ['label' => $name, 'url' => ['student/view', 'id' => $model->student_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="student-semester-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
