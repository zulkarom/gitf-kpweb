<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\erpd\models\AwardSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="award-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'awd_staff') ?>

    <?= $form->field($model, 'awd_name') ?>

    <?= $form->field($model, 'awd_level') ?>

    <?= $form->field($model, 'awd_type') ?>

    <?php // echo $form->field($model, 'awd_by') ?>

    <?php // echo $form->field($model, 'awd_date') ?>

    <?php // echo $form->field($model, 'awd_file') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
