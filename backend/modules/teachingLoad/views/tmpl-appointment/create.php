<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\TmplAppointment */

$this->title = 'Create Tmpl Appointment';
$this->params['breadcrumbs'][] = ['label' => 'Tmpl Appointments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tmpl-appointment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
