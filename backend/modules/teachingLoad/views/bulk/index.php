<?php
use backend\models\Semester;
use kartik\widgets\ActiveForm;

$this->title = 'Auto Load Assignment';
$this->params['breadcrumbs'][] = ['label' => 'Courses Offered', 'url' => ['/teaching-load/course-offered/index']];
$this->params['breadcrumbs'][] = $this->title;

$form = ActiveForm::begin([
'id' => 'form-autoload'
]); ?>  
<div class="row">
	
<div class="col-md-5">
<?= $form->field($semester, 'semester_id')->dropDownList(
        Semester::listSemesterArray()
    )->label(false) ?>
</div>
</div>

<div class="form-group">   
<button type="button" class="btn btn-warning" id="btn-run"><span class="fa fa-gears"></span>  RUN AUTOLOAD</button>

<button type="button" id="btn-delete" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> DELETE ALL LOADING </button></div>

<input type="hidden" name="btn-action" id="btn-action" value="" />
<?php 

if($result){
?>
<div class="box" style="background-color:#000000;color:#FFFFFF">
<div class="box-body">
<?php

	$i = 1;
	foreach($result as $msg){
	$break = $i == 1 ? '' : '<br />';
	echo '<span style="font-weight: normal;font-family:Courier">' . $break.$msg . '</span>';
	$i++;
	}
?>
</div>
</div>
<?php
}
ActiveForm::end(); 
?>

<?php 
$this->registerJs('
$("#btn-run").click(function(){
	$("#btn-action").val(1);
	if(confirm("Are you sure to run this autoload?")){
		$("#form-autoload").submit();
	}
	
});
$("#btn-delete").click(function(){
	$("#btn-action").val(0);
	if(confirm("Are you sure to delete all teaching load? Please note that this action cannot be undone.")){
		$("#form-autoload").submit();
	}
});

');

?>