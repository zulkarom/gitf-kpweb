<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use common\models\UploadFile;

/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\CourseOffered */
$course = $model->course;
$title = 'Plan for Course Improvement';
$this->title = $course->course_code . ' ' . $course->course_name;
$this->params['breadcrumbs'][] = ['label' => 'Course Files', 'url' => ['/course-files/default/teaching-assignment-coordinator', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $title;

?>

<h4>
<?=$title?>
</h4>

  <div class="box">

<div class="box-body">
<?php $form = ActiveForm::begin(); ?>

<div class="row">
<div class="col-md-8"><?php 
$display = $model->na_cqi == 1 ? 'display:none' : '';
echo $form->field($model, 'course_cqi')->textarea(['rows' => '6', 'style' => $display])->label('Course Improvement') ?></div>

</div>

<?php 
$check_na = $model->na_cqi == 1 ? 'checked' : ''; 
?>

<div class="form-group"><label>
<input type="checkbox" id="na" name="na" value="1" <?=$check_na?> /> Mark as not applicable
</label></div>

 <div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Save', ['class' => 'btn btn-success']) ?>
    </div>
	

    <?php ActiveForm::end(); ?>
</div></div>

<?php 

$this->registerJs('

$("#na").click(function(){
	if( $(this).prop("checked") == true){
		$("#courseoffered-course_cqi").slideUp();
		
	}else{
		$("#courseoffered-course_cqi").slideDown();
	}
});

');


?>