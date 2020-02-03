<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use backend\modules\staff\models\Staff;
use kartik\select2\Select2;

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


<div class="field-consultation_tag">
<div class="row">

<div class="col-md-8">
<label class="control-label" for="consultation_tag">Tagged Staff</label>
<?php 
echo Select2::widget([
    'name' => 'tagged_staff',
    'value' => ArrayHelper::map($model->consultationTagsNotMe,'id','staff_id'),
    'data' => ArrayHelper::map(Staff::activeStaffNotMe(), 'id', 'staff_name'),
    'options' => ['multiple' => true, 'placeholder' => 'Select '.Yii::$app->params['faculty_abbr'].' Staff ...']
]);

?>

</div>
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