<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use common\models\UploadFile;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\CourseOffered */

$this->title = 'Lecturer ['.$model->lec_name.']';
$this->params['breadcrumbs'][] = ['label' => 'Teaching Load', 'url' => ['/course-files/default/teaching-assignment']];
$this->params['breadcrumbs'][] = ['label' => 'Lecturer ['.$model->lec_name.']', 'url' => ['/course-files/default/teaching-assignment-lecture', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Class Cancellation';
$course = $model->courseOffered->course;
?>


<h4><?=$course->course_code . ' ' . $course->course_name?> - <?=$model->courseOffered->semester->longFormat()?></h4>

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
<?php $form = ActiveForm::begin(); ?>
 <div class="box box-primary">

<div class="box-body">

<table class="table table-striped table-hover">


<thead>
  <tr>
  <th width="5%">#</th>
  <th width="20%">Cancellation Date</th>
  <th width="20%">Replacement Date</th>
  <th>Upload File</th>
  </tr>
</thead>

<tbody>
	<?php 
	$applicable = false;
	if($files){
		$i=1;
		foreach($files as $x=>$file){
			$file->scenario = 'saveall';
			$file->file_controller = 'lecture-cancel-file';
			if($file->date_old == '0000-00-00'){
				$file->date_old = date('Y-m-d');
			}
			if($file->date_new == '0000-00-00'){
				$file->date_new = date('Y-m-d');
			}
			?>
			<tr>
			<td><?=$i?>. </td>
			<td>
			<?=Html::activeHiddenInput($file, "[{$x}]id");?>
			
			 <?=$form->field($file, "[{$x}]date_old")->widget(DatePicker::classname(), [
    'removeButton' => false,
	'pickerIcon' => '<i class="fa fa-calendar"></i>',
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
        
    ],
    
    
])->label(false);
?>


			
			</td>
			<td>

			 <?=$form->field($file, "[{$x}]date_new")->widget(DatePicker::classname(), [
    'removeButton' => false,
	'pickerIcon' => '<i class="fa fa-calendar"></i>',
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
        
    ],
    
    
])->label(false);
?>


			
			</td>
				<td><?=UploadFile::fileInput($file, 'path', false, true, 'material-item')?></td>
			</tr>
			<?php
		$i++;
		
			
		}
	}else{
			echo '<tr><td colspan="4">No Files</td></tr>';
			$applicable = true;
		}
	
	?>
</tbody>
</table>
</div>
</div>
<?php 
$check_na = $model->na_class_cancel == 1 ? 'checked' : ''; 
$check_complete = $model->prg_class_cancel == 1 ? 'checked' : ''; 
?>

<?php if(!$applicable){ ?>
<div class="form-group"><label>
<input type="checkbox" id="complete" name="complete" value="1" <?=$check_complete?> /> Mark as complete
</label></div>
<?php } ?>

<?php if($applicable){ ?>
<div class="form-group"><label>
<input type="checkbox" id="na" name="na" value="1" <?=$check_na?> /> Mark as not applicable
</label></div>
<?php } ?>

<div class="form-group">
<?=$form->field($model, 'updated_at')->hiddenInput(['value' => time()])->label(false)?>
	<?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> Save', ['class' => 'btn btn-success']) ?>
</div>
	
    <?php ActiveForm::end(); ?>