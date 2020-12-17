<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\TmplAppointmentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tmpl-appointment-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'template_name') ?>

    <?= $form->field($model, 'dekan') ?>

    <?= $form->field($model, 'yg_benar') ?>

    <?= $form->field($model, 'tema') ?>

    <?php // echo $form->field($model, 'per1') ?>

    <?php // echo $form->field($model, 'signiture_file') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
