<?php
use backend\models\Semester;
use kartik\widgets\ActiveForm;

$this->title = 'Auto Load Assignment';


$form = ActiveForm::begin(); ?>  
<div class="row">
	
<div class="col-md-5">
<?= $form->field($semester, 'semester_id')->dropDownList(
        Semester::listSemesterArray()
    )->label(false) ?>
</div>
</div>

<div class="form-group">   <button class="btn btn-danger"> RUN AUTOLOAD</button></div>

<div class="box box-danger">
<div class="box-header"></div>
<div class="box-body">


<?php var_dump($result)?>


</div>
</div>

<?php ActiveForm::end(); ?>