<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\SemesterModule */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="semester-module-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'student_sem_id')->textInput() ?>

    <?= $form->field($model, 'module_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
