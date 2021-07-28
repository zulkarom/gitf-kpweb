<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\modules\erpd\models\Membership */
/* @var $form yii\widgets\ActiveForm */
?>
    <?php $form = ActiveForm::begin(); ?>
<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="membership-form">


	
	<div class="row">
<div class="col-md-8"> 

<?php 

if($model->id){
	echo $form->field($model, 'msp_body', ['template' => '{label}<div id="con-body">{input}</div>{error}'])->textInput();
}else{
	echo $form->field($model, 'msp_body', ['template' => '{label}<div id="con-body">{input}</div>{error}'])->dropDownList($model->membershipBodySample());
}


?>


</div>



</div>

<div class="row">
<div class="col-md-4">

<?php 

if($model->id){
	echo $form->field($model, 'msp_type', ['template' => '{label}<div id="con-type">{input}</div>{error}'])->textInput();
}else{
	echo $form->field($model, 'msp_type', ['template' => '{label}<div id="con-type">{input}</div>{error}'])->dropDownList($model->membershipTypeSample());
}



?>


</div>

</div>




   
<div class="row">


<div class="col-md-2">



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
<?php 
$check = 'checked';
$hide = 'style="display:none"';
if($model->date_end){
	$check = '';
	$hide = '"';
} 
?>

<div class="col-md-2" id="con-end" <?=$hide?>>
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

<div class="col-md-2"><div class="form-group">&nbsp;</div> <div class="form-group"><label><input id="check-end" type="checkbox" name="[Membership]checknoend" value="1" <?=$check?> /> No End</label></div></div>

</div>

<div class="row">
<div class="col-md-6"><?= $form->field($model, 'msp_level')->dropDownList( $model->listLevel() ) ?></div>

</div>
    



   

</div></div>
</div>

    <div class="form-group">
		
		<?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> SAVE AS DRAFT', ['class' => 'btn btn-default', 'name' => 'wfaction', 'value' => 'save']) ?> 
		
		
		
		 <?= Html::submitButton('NEXT <span class="glyphicon glyphicon-arrow-right"></span>', ['class' => 'btn btn-warning', 'name' => 'wfaction', 'value' => 'next']) ?> 
		 
    </div>

 <?php ActiveForm::end(); ?>
 
 <?php
$js = <<<'EOD'

$('#membership-msp_body').change(function(){
	var val = $(this).val();
	if(val == 999){
		var html = '<input type="text" id="membership-msp_body" placeholder="Please specify" class="form-control" name="Membership[msp_body]" / >';
		$("#con-body").html(html);
		
	}
});

$('#membership-msp_type').change(function(){
	var val = $(this).val();
	if(val == 999){
		var html = '<input type="text" id="membership-msp_type" placeholder="Please specify" class="form-control" name="Membership[msp_type]" / >';
		$("#con-type").html(html);
		
	}
});

$('#check-end').click(function(){
	if($(this).is(':checked')){
		$('#con-end').hide(100);
	}else{
		$('#con-end').show(100);
	}
	
});


EOD;

$this->registerJs($js);
?>