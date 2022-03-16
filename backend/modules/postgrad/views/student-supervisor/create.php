<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\StudentSupervisor */

$this->title = 'Add Supervisor: ' . $student->user->fullname;
$this->params['breadcrumbs'][] = ['label' => 'Student Supervisors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="student-supervisor-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
