<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;


$this->title = 'Teaching Setting';
?>

<?php $form = ActiveForm::begin(); ?>

<div class="box box-primary">
<div class="box-body">

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

</div>


<div class="row">
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



</div>
</div>


<div class="form-group">
        
<?= Html::submitButton('SAVE', ['class' => 'btn btn-success']) ?>
    </div>
	
	
  <?php ActiveForm::end(); ?>