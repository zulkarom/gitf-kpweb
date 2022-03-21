<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\University */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="university-form">

    <?php $form = ActiveForm::begin(); ?>
    
     <div class="box">
<div class="box-header"></div>
<div class="box-body">

<div class="row">
	<div class="col-md-6">  <?= $form->field($model, 'uni_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'uni_name_en')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'uni_abbr')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'thrust')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'main_location')->textInput(['maxlength' => true]) ?></div>
	<div class="col-md-6"></div>
</div>




</div>
</div>

  

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
