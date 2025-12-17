<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\StudentRegister */

$this->title = 'Add Semester: ' . $student->user->fullname;


$this->params['breadcrumbs'][] = ['label' => 'Students', 'url' => ['student/index']];
$this->params['breadcrumbs'][] = ['label' => $student->user->fullname, 'url' => ['student/view', 'id' => $student->id]];
$this->params['breadcrumbs'][] = 'Add Semester';


?>
<div class="student-register-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
