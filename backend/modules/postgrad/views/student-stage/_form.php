<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Semester;
use backend\modules\staff\models\Staff;
use kartik\date\DatePicker;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\StudentStage */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="student-stage-form">

    <?php $form = ActiveForm::begin(); ?>
    
    
     <div class="box">
<div class="box-header"></div>
<div class="box-body">

<div class="row">
	<div class="col-md-6">
	
	
	    <?= $form->field($model, 'stage_id')->dropDownList($model->stageListArray) ?>
	    
	     <?= $form->field($model, 'semester_id')->dropDownList($model->regSemesters(), ['prompt' => 'Select..']) ?>
    
    

 <?=$form->field($model, 'stage_date')->widget(DatePicker::classname(), [
    'removeButton' => false,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
        
    ],
    
    
]);
?>

<?php 

echo $form->field($model, 'chairman_id')->widget(Select2::classname(), [
    'data' => Staff::listAcademicStaffArray(),
    'options' => ['placeholder' => 'Select ..'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);

?>

    

    <?= $form->field($model, 'status')->dropDownList($model->statusList()) ?>
    
    <?= $form->field($model, 'remark')->textarea() ?>
	
	
	</div>
	<div class="col-md-6"></div>
</div>




</div>
</div>




    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
