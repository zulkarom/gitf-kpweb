<?php
use backend\models\Semester;
use kartik\widgets\ActiveForm;
?>

<?php 

$form = ActiveForm::begin([
'id' => 'sel-sem-session-form',
'action' => $model->action,
'method' => 'get',

]); ?>  
<div class="row">
	
<div class="col-md-5">
<?= $form->field($model, 'semester_id')->dropDownList(
        Semester::listSemesterArray()
    )->label(false) ?>
</div>

</div>
    <?php ActiveForm::end(); ?>

<?php 

$this->registerJs('

$("#semesterform-semester_id").change(function(){
	$("#sel-sem-session-form").submit();
});

');

?>