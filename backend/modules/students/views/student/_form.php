<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\students\models\Student */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="student-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'matric_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nric')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'st_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'program')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_active')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div></div>
</div>
