<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\erpd\models\KnowledgeTransferSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="knowledge-transfer-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'ktp_title') ?>

    <?= $form->field($model, 'staff_id') ?>

    <?= $form->field($model, 'date_start') ?>

    <?= $form->field($model, 'date_end') ?>

    <?php // echo $form->field($model, 'ktp_research') ?>

    <?php // echo $form->field($model, 'ktp_community') ?>

    <?php // echo $form->field($model, 'ktp_source') ?>

    <?php // echo $form->field($model, 'ktp_amount') ?>

    <?php // echo $form->field($model, 'ktp_description') ?>

    <?php // echo $form->field($model, 'ktp_file') ?>

    <?php // echo $form->field($model, 'reminder') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
