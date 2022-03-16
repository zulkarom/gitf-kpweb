<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\StudentSupervisor */

$this->title = 'Update Supervisor: ' . $model->student->user->fullname;
$this->params['breadcrumbs'][] = ['label' => 'Student Supervisors', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="student-supervisor-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
