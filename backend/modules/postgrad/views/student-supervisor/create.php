<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\StudentSupervisor */

$this->title = 'Add Supervisor: ' . $student->user->fullname;


$this->params['breadcrumbs'][] = ['label' => 'Students', 'url' => ['student/index']];
$this->params['breadcrumbs'][] = ['label' => $student->user->fullname, 'url' => ['student/view', 'id' => $student->id]];

$this->params['breadcrumbs'][] = 'Add Supervisor';
?>
<div class="student-supervisor-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
