<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\StudentSupervisor */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="student-supervisor-form">

    <?php $form = ActiveForm::begin(); ?>
    
    
     <div class="box">
<div class="box-header"></div>
<div class="box-body">

<div class="row">
	<div class="col-md-6">
	
	<?php 
	//print_r($model->supervisorListArray());

echo $form->field($model, 'supervisor_id')->widget(Select2::classname(), [
    'data' => $model->supervisorListArray(),
    'options' => ['placeholder' => 'Select ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);

?>
	
	
	
	 <?= $form->field($model, 'sv_role')->dropDownList($model->roleList()) ?>


 <?=$form->field($model, 'appoint_at')->widget(DatePicker::classname(), [
    'removeButton' => false,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
        
    ],
    
    
]);
?>
    
	
	
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
