<?php
use backend\models\Semester;
use backend\modules\esiap\models\Program;
use backend\modules\teachingLoad\models\CourseOffered;
use kartik\widgets\ActiveForm;
?>

<?php 

$form = ActiveForm::begin([
'id' => 'sel-sem-form',
'action' => $model->action,
'method' => 'get',

]); ?>  
<div class="row">
    
<div class="col-md-3">
<?= $form->field($model, 'semester_id')->dropDownList(
        Semester::listSemesterArray()
    )->label(false) ?>
</div>

<div class="col-md-2">
<?= $form->field($model, 'program_id') ->dropDownList(
        Program::getProgramActiveFileArray(), ['prompt' => 'Select Program' ]
    )->label(false) ?>
</div>
<div class="col-md-2">
<?= $form->field($model, 'prg_overall') ->dropDownList(
    CourseOffered::getProgressGroup(), ['prompt' => 'Select Progress' ]
    )->label(false) ?>
</div>
<div class="col-md-2">
<?= $form->field($model, 'status') ->dropDownList(
        CourseOffered::getStatusArray(), ['prompt' => 'Select Status' ]
    )->label(false) ?>
</div>
<div class="col-md-2">
<?= $form->field($model, 'is_audited') ->dropDownList(
       [1 => 'Yes', 0 => 'No'], ['prompt' => 'Select Audited' ]
    )->label(false) ?>
</div>



</div>
    <?php ActiveForm::end(); ?>

<?php 

$this->registerJs('

$("#semesterform-semester_id").change(function(){
    $("#sel-sem-form").submit();
});

$("#semesterform-program_id").change(function(){
    $("#sel-sem-form").submit();
});

$("#semesterform-prg_overall").change(function(){
    $("#sel-sem-form").submit();
});

$("#semesterform-status").change(function(){
    $("#sel-sem-form").submit();
});

$("#semesterform-is_audited").change(function(){
    $("#sel-sem-form").submit();
});



');

?>
