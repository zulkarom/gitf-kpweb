<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

?>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($thesis, 'thesis_title')->textInput(['maxlength' => true]) ?>

<?= $form->field($thesis, 'date_applied')->widget(DatePicker::classname(), [
    'removeButton' => false,
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
    ],
]) ?>

<?= $form->field($thesis, 'is_active')->dropDownList([
    1 => 'Yes',
    0 => 'No',
]) ?>

<div class="form-group">
    <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
