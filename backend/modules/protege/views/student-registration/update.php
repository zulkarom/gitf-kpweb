<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\protege\models\StudentRegistration */

$this->title = 'Update Student Registration: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Student Registrations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="student-registration-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
