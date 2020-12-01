<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\proceedings\models\ProjectSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="paper-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'proc_id') ?>

    <?= $form->field($model, 'paper_title') ?>

    <?= $form->field($model, 'author') ?>

    <?= $form->field($model, 'paper_no') ?>

    <?php // echo $form->field($model, 'paper_page') ?>

    <?php // echo $form->field($model, 'paper_url') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
