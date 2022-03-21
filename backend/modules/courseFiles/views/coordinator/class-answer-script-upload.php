<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use common\models\UploadFile;

/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\CourseOffered */
$course = $model->course;
$this->title = $course->course_code . ' '  . $course->course_name;
$this->params['breadcrumbs'][] = ['label' => 'My Course File', 'url' => ['/course-files/default/teaching-assignment']];
$this->params['breadcrumbs'][] = ['label' => 'Coordinator', 'url' => ['/course-files/default/teaching-assignment-coordinator', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Student’s Final Exam Answer Scripts';

$model->file_controller = 'coordinator-upload';
?>

<h4><?=$model->semester->longFormat()?></h4>
<h4>Nine (9) Copies of Student’s Final Exam Answer Scripts</h4>

<?php 
if($model->na_script_final == 1){
	$check_na = 'checked';
	$show_form = 'style="display:none"';
}else{
	$show_form = '';
	$check_na = '';
}



?>

  <div id="con-form" class="box box-primary" <?=$show_form ?>>

<div class="box-body">


<table class="table">
<thead>
<tr>
	<th width="5%">#</th>
	<th width="30%">Document Title</th>
	<th>Upload File</th>
</tr>
<thead>
<tbody>
	<tr>
		<td>1. </td>
		<td>Best Answer Script 1</td>
		<td>
<?=UploadFile::fileInput($model, 'scriptbest1', false, false, 'single-simple')?>
</td>
	</tr>
	
	<tr>
		<td>2. </td>
		<td>Best Answer Script 2</td>
		<td><?=UploadFile::fileInput($model, 'scriptbest2', false, false, 'single-simple')?></td>
	</tr>
	
	<tr>
		<td>3. </td>
		<td>Best Answer Script 3</td>
		<td><?=UploadFile::fileInput($model, 'scriptbest3', false, false, 'single-simple')?></td>
	</tr>
	
	<tr>
		<td>4. </td>
		<td>Moderate Answer Script 1</td>
		<td><?=UploadFile::fileInput($model, 'scriptmod1', false, false, 'single-simple')?></td>
	</tr>
	
	<tr>
		<td>5. </td>
		<td>Moderate Answer Script 2</td>
		<td><?=UploadFile::fileInput($model, 'scriptmod2', false, false, 'single-simple')?></td>
	</tr>
	
	<tr>
		<td>6. </td>
		<td>Moderate Answer Script 3</td>
		<td><?=UploadFile::fileInput($model, 'scriptmod3', false, false, 'single-simple')?></td>
	</tr>
	
	<tr>
		<td>7. </td>
		<td>Lowest Answer Script 1</td>
		<td><?=UploadFile::fileInput($model, 'scriptlow1', false, false, 'single-simple')?></td>
	</tr>
	
	<tr>
		<td>8. </td>
		<td>Lowest Answer Script 2</td>
		<td><?=UploadFile::fileInput($model, 'scriptlow2', false, false, 'single-simple')?></td>
	</tr>
	
	<tr>
		<td>9. </td>
		<td>Lowest Answer Script 3</td>
		<td><?=UploadFile::fileInput($model, 'scriptlow3', false, false, 'single-simple')?></td>
	</tr>
	
</tbody>
</table>
<br />

</div></div>


<?php 
$form = ActiveForm::begin(); 
?>

<div class="form-group"><label>
<input type="checkbox" id="na" name="na" value="1" <?=$check_na?> /> Mark as not applicable
</label></div>

<?php 
$check_complete = $model->prg_sum_script == 1 ? 'checked' : ''; 
?>
<div class="form-group"><label>
<input type="checkbox" id="complete" name="complete" value="1" <?php echo $check_complete;?>  /> Mark as complete
</label></div>



 <div class="form-group">
  <?=$form->field($model, 'updated_at')->hiddenInput(['value' => time()])->label(false)?>
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Save', ['class' => 'btn btn-success']) ?>
    </div>


    <?php ActiveForm::end(); ?>

<?php 
$this->registerJs('
$("#na").click(function(){
	var val = $(this).prop(\'checked\')

	if(val){
		$("#con-form").slideUp();
	}else{
		$("#con-form").slideDown();
	}
});

');



?>