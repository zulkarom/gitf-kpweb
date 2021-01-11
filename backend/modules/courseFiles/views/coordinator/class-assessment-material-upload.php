<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use common\models\UploadFile;

/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\CourseOffered */
$course = $model->course;
$title = 'Continous Assessment Materials';
$this->title = $course->course_code . ' ' . $course->course_name;
$this->params['breadcrumbs'][] = ['label' => 'Course Files', 'url' => ['/course-files/default/teaching-assignment-coordinator', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $title;

?>

<h4>
<?=$title?>
</h4>

<div class="form-group"><?php $form = ActiveForm::begin(); 
	
	$addFile->file_number = 1;
	echo $form->field($addFile, 'file_number', [
                    'template' => 'Add Files: {input}',
                    'options' => [
						
                        'tag' => false, // Don't wrap with "form-group" div
                    ]])->textInput(['style' => 'width:50px', 'type' => 'number', 'class' => ''])->label(false);

	echo Html::submitButton('Go', ['class' => 'btn btn-sm btn-default']);
	ActiveForm::end(); ?></div>
  <div class="box">

<div class="box-body">
<?php $form = ActiveForm::begin(); ?>
<table class="table table-striped table-hover">

  <thead>
  <tr>
  <th width="5%">#</th>
  <th width="40%">Document Title</th>
  <th>Upload File</th>
  </tr>
</thead>

<tbody>
	<?php 
	if($files){
		$i=1;
		foreach($files as $x=>$file){
			$file->scenario = 'saveall';
			$file->file_controller = 'coordinator-assessment-material-file';
			?>
			<tr>
			<td><?=$i?>. </td>
			<td>
			<?=Html::activeHiddenInput($file, "[{$x}]id");?>
			<?=Html::activeHiddenInput($model, "id");?>
			<?= $form->field($file, "[{$x}]file_name")->label(false) ?>
			
			</td>
				<td><?=UploadFile::fileInput($file, 'path', false, true, 'material-item')?></td>
			</tr>
			<?php
		$i++;
		
			
		}
	}
	
	?>
</tbody>
</table>
 <div class="form-group">
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div></div>

