<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model student\models\KursusPesertaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kursus-peserta-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'anjur_id') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'submitted_at') ?>

    <?php // echo $form->field($model, 'paid_at') ?>

    <?php // echo $form->field($model, 'is_paid') ?>

    <?php // echo $form->field($model, 'payment_method') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
