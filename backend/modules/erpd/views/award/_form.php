<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\modules\erpd\models\Award */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="award-form">

    <?php $form = ActiveForm::begin(); ?>
	
	<div class="row">
<div class="col-md-8"><?= $form->field($model, 'awd_name')->dropDownList($model->awardNameSample())?></div>

</div>

<div class="row">
<div class="col-md-8"> <?= $form->field($model, 'awd_by')->dropDownList($model->awardedBySample()) ?></div>

</div>

<div class="row">
<div class="col-md-4"> <?= $form->field($model, 'awd_type')->dropDownList($model->awardTypeSample()) ?></div>

<div class="col-md-2">



 <?=$form->field($model, 'awd_date')->widget(DatePicker::classname(), [
    'removeButton' => false,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
        
    ],
    
    
]);?>
</div>

</div>

<div class="row">
<div class="col-md-6"><?= $form->field($model, 'awd_level')->dropDownList($model->listLevel()) ?></div>

<div class="col-md-6">
</div>

</div>

    

    

   

   

    


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
