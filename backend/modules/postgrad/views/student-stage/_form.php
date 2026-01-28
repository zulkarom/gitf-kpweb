<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\Semester;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use kartik\time\TimePicker;

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
	    
	     <?= $form->field($model, 'semester_id')->dropDownList($model->regSemesters($student->id), ['prompt' => 'Select..']) ?>
    
    




    

    <?= $form->field($model, 'status')->dropDownList($model->statusList()) ?>
    
    <?= $form->field($model, 'thesis_title')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'remark')->textarea() ?>
	
	
	</div>
	<div class="col-md-6">

<div class="row">
	<div class="col-md-6">
<?=$form->field($model, 'stage_date')->widget(DatePicker::classname(), [
    'removeButton' => false,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
        
    ],
    
    
]);
?>
    </div>
    <div class="col-md-6"> 	<?= $form->field($model, 'stage_time')->widget(TimePicker::classname(), [
	        	    'pluginOptions' => [
	        	        'showSeconds' => false,
	        	        'minuteStep' => 5,
	        	    ],
	        	]) ?>
 </div>
</div>
    
       

	<?= $form->field($model, 'meeting_mode')->dropDownList($model->meetingModeList(), ['prompt' => 'Select..']) ?>

	<?= $form->field($model, 'location')->textInput() ?>

	<?= $form->field($model, 'meeting_link')->textInput() ?>
    </div>
</div>




</div>
</div>




    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
