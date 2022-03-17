<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\StudentStage */

$this->title = 'Update Stage: ' . $model->student->user->fullname;
$this->params['breadcrumbs'][] = ['label' => 'Student Stages', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="student-stage-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
