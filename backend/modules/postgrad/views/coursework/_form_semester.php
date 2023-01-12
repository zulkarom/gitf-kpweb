<?php
use backend\models\Semester;
use backend\modules\esiap\models\Program;
use kartik\widgets\ActiveForm;
?>

<?php 

$form = ActiveForm::begin([
'id' => 'sel-sem-form',
'method' => 'get',

]); ?>  
<div class="row">
    
<div class="col-md-5">
<?= $form->field($model, 'semester_id')->dropDownList(
        Semester::listSemesterArray()
    )->label(false) ?>
</div>
<div class="col-md-2">
<?= $form->field($model, 'program_id') ->dropDownList(
        Program::getProgramActiveFileArray(), ['prompt' => 'Select Program' ]
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

//semesterform-program_id

');

?>