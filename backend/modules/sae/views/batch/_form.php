<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model backend\models\Batch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box">
<div class="box-body">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'bat_text')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'bat_show')->dropDownList( [1 => 'Yes' , 0 => 'No'] )?>
        </div>
    </div>
      <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'allow_register')->dropDownList( [1 => 'Yes' , 0 => 'No'] )?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'allow_update')->dropDownList( [1 => 'Yes' , 0 => 'No'] )?>
        </div>
    </div>
  
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'is_open')->dropDownList( [1 => 'Yes' , 0 => 'No'] )?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <?=$form->field($model, 'start_date')->widget(DatePicker::classname(), [
                    'removeButton' => false,
                    'pickerIcon' => '<i class="fa fa-calendar"></i>',
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true,   
                    ],
                ]);
            ?>
        </div>
        <div class="col-md-3">
            <?=$form->field($model, 'end_date')->widget(DatePicker::classname(), [
                    'removeButton' => false,
                    'pickerIcon' => '<i class="fa fa-calendar"></i>',
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy-mm-dd',
                        'todayHighlight' => true,   
                    ],
                ]);
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'column1')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'column2')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'column3')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'column4')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save Batch', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>


</div>
</div>

