<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\widgets\ActiveForm;
use backend\models\Component;
use backend\models\Semester;
use backend\modules\esiap\models\Course;
use backend\modules\esiap\models\CourseVersion;
use backend\modules\esiap\models\Program;
use backend\modules\teachingLoad\models\CourseOffered;

/* @var $this yii\web\View */
/* @var $model backend\models\ClaimSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin([
	'id' => 'form-index-course',
    'method' => 'get',
]); ?>
    
<div class="row">
<div class="col-md-6">
	
<?= $form->field($model, 'semester_id')->dropDownList(
        Semester::listSemesterArray()
    )->label(false) ?>



</div>


<div class="col-md-3">

<?= $form->field($model, 'status') ->dropDownList(
       CourseVersion::getStatusArray(), ['prompt' => 'Select Status' ]
    )->label(false) ?>

</div>



</div>

<?php ActiveForm::end(); ?>


<?php 
$this->registerJs('
$("#semesterform-semester_id").change(function(){
	$("#form-index-course").submit();
});

$("#semesterform-status").change(function(){
	$("#form-index-course").submit();
});


');

?>