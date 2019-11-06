<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use backend\modules\staff\models\Staff;

/* @var $this yii\web\View */
/* @var $model backend\modules\erpd\models\Award */
/* @var $form yii\widgets\ActiveForm */
?>
    <?php $form = ActiveForm::begin(); ?>
<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="award-form">


	
	<div class="row">
<div class="col-md-8">


<?php 

if($model->id){
	echo $form->field($model, 'awd_name', ['template' => '{label}<div id="con-name">{input}</div>{error}'])->textInput();
}else{
	echo $form->field($model, 'awd_name',  ['template' => '{label}<div id="con-name">{input}</div>{error}'])->dropDownList($model->awardNameSample());
}


?>



</div>

</div>

<div class="row">
<div class="col-md-8"> 

<?php 

if($model->id){
	echo $form->field($model, 'awd_by', ['template' => '{label}<div id="con-by">{input}</div>{error}'])->textInput();
}else{
	
	echo $form->field($model, 'awd_by', ['template' => '{label}<div id="con-by">{input}</div>{error}'])->dropDownList($model->awardedBySample());
}


?>



</div>

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

<div class="field-award-pub_tag">
<div class="row">

<div class="col-md-8">
<label class="control-label" for="award-pub_tag">Tagged Staff</label>
<?php 
echo Select2::widget([
    'name' => 'tagged_staff',
    'value' => ArrayHelper::map($model->awardTagsNotMe,'id','staff_id'),
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

 <?php
$js = <<<'EOD'

$('#award-awd_name').change(function(){
	var val = $(this).val();
	if(val == 999){
		var html = '<input type="text" id="award-awd_name" placeholder="Please specify" class="form-control" name="Award[awd_name]" / >';
		$("#con-name").html(html);
		
	}
});


$('#award-awd_by').change(function(){
	var val = $(this).val();
	if(val == 999){
		var html = '<input type="text" id="award-awd_by" placeholder="Please specify" class="form-control" name="Award[awd_by]" / >';
		$("#con-by").html(html);
		
	}
});


EOD;

$this->registerJs($js);
?>