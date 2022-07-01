<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Question */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="question-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'que_text')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'que_text_bi')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'display_cat')->textInput() ?>

    <?= $form->field($model, 'grade_cat')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
