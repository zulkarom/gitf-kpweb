<?php
use backend\models\Semester;
use kartik\widgets\ActiveForm;
?>

<?php 

$form = ActiveForm::begin([
'id' => 'sel-sem-form',
'action' => $model->action,
'method' => 'get',

]); ?>  
<div class="row">
	
<div class="col-md-5">
<?= $form->field($model, 'semester_id')->dropDownList(
        Semester::listSemesterArray()
    )->label(false) ?>
</div>
<div class="col-md-4">
<?= $form->field($model, 'str_search', ['addon' => ['prepend' => ['content'=>'<span class="glyphicon glyphicon-search"></span>']]])->label(false)->textInput(['placeholder' => "Search..."]) ?>
</div>
</div>
    <?php ActiveForm::end(); ?>

<?php 

$this->registerJs('

$("#semesterform-semester_id").change(function(){
	$("#sel-sem-form").submit();
});

');

?>