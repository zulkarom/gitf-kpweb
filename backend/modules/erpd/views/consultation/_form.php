<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\modules\erpd\models\Consultation */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(); ?>

<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="consultation-form">

    
	
<div class="row">
<div class="col-md-9"><?= $form->field($model, 'csl_title')->textInput(['maxlength' => true]) ?></div>
</div>

<div class="row">
<div class="col-md-6"><?= $form->field($model, 'csl_funder')->textInput(['maxlength' => true]) ?></div>
</div>

    <div class="row">
<div class="col-md-3">

<?= $form->field($model, 'csl_amount', [
    'addon' => ['prepend' => ['content'=>'RM']]
]); ?>

</div>

</div>


<div class="row">
<div class="col-md-3"> 
 <?=$form->field($model, 'date_start')->widget(DatePicker::classname(), [
    'removeButton' => false,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
    ],
]);
?>
</div>

<div class="col-md-3"> 
 <?=$form->field($model, 'date_end')->widget(DatePicker::classname(), [
    'removeButton' => false,
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
<div class="col-md-4"><?= $form->field($model, 'csl_level')->dropDownList($model->listLevel()) ?>
</div>
</div>

   
    

</div>
</div>
</div>


<div class="form-group">
		
		<?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> SAVE AS DRAFT', ['class' => 'btn btn-default', 'name' => 'wfaction', 'value' => 'save']) ?> 
		
		
		
		 <?= Html::submitButton('NEXT <span class="glyphicon glyphicon-arrow-right"></span>', ['class' => 'btn btn-warning', 'name' => 'wfaction', 'value' => 'next']) ?> 
		 
    </div>

<?php ActiveForm::end(); ?>