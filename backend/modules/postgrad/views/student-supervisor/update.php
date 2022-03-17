<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\StudentSupervisor */

$this->title = 'Update Supervisor: ' . $model->student->user->fullname;



$this->params['breadcrumbs'][] = ['label' => 'Students', 'url' => ['student/index']];
$this->params['breadcrumbs'][] = ['label' => $model->student->user->fullname, 'url' => ['student/view', 'id' => $model->student->id]];
$this->params['breadcrumbs'][] = 'Update';



?>
<div class="student-supervisor-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
