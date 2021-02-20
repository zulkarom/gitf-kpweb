<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use common\models\UploadFile;

/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\CourseOffered */

$this->title = 'Tutor ['.$model->tutorial_name.']';
$this->params['breadcrumbs'][] = ['label' => 'Teaching Load', 'url' => ['/course-files/default/teaching-assignment']];
$this->params['breadcrumbs'][] = ['label' => 'Course Files', 'url' => ['/course-files/default/teaching-assignment-tutorial', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
$course = $model->lecture->courseOffered->course;
?>


<h4><?=$course->course_code . ' ' . $course->course_name?></h4>
<h4><?=$model->lecture->courseOffered->semester->longFormat()?></h4>

<br />
<h4>Record of Class Cancellation and Replacement (if applicable)</h4>
<div class="form-group"><?php $form = ActiveForm::begin(); 
	
	$addFile->file_number = 1;
	echo $form->field($addFile, 'file_number', [
                    'template' => 'Add Files: {input}',
                    'options' => [
						
                        'tag' => false, // Don't wrap with "form-group" div
                    ]])->textInput(['style' => 'width:50px', 'type' => 'number', 'class' => ''])->label(false);

	echo Html::submitButton('Go', ['class' => 'btn btn-sm btn-default']);
	ActiveForm::end(); ?></div>



  <div class="box box-primary">

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
			$file->file_controller = 'tutorial-cancel-file';
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


