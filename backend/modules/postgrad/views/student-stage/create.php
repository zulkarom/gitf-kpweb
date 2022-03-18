<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\StudentStage */

$this->title = 'Add Stage: ' . $student->user->fullname;

$this->params['breadcrumbs'][] = ['label' => 'Students', 'url' => ['student/index']];
$this->params['breadcrumbs'][] = ['label' => $student->user->fullname, 'url' => ['student/view', 'id' => $student->id]];
$this->params['breadcrumbs'][] = 'Add Stage';


?>
<div class="student-stage-create">



    <?= $this->render('_form', [
        'model' => $model,
        'student' => $student
    ]) ?>

</div>
