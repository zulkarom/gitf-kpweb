<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\protege\models\StudentRegistration */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="student-registration-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'company_offer_id')->textInput() ?>

    <?= $form->field($model, 'student_matric')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'student_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'program_abbr')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'register_at')->textInput() ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
