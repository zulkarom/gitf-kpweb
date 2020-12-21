<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\TmplAppointment */
$this->title = 'Update Template';
$this->params['breadcrumbs'][] = ['label' => 'Tmpl Appointments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tmpl-appointment-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
