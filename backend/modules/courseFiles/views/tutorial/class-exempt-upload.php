<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use common\models\UploadFile;
use kartik\date\DatePicker;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\modules\teachingLoad\models\CourseOffered */

$this->title = 'Tutor ['.$model->lecture->lec_name.$model->tutorial_name.']';
$this->params['breadcrumbs'][] = ['label' => 'Teaching Load', 'url' => ['/course-files/default/teaching-assignment']];
$this->params['breadcrumbs'][] = ['label' => 'Tutor ['.$model->lecture->lec_name.$model->tutorial_name.']', 'url' => ['/course-files/default/teaching-assignment-tutorial', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Class Exemption';
$course = $model->lecture->courseOffered->course;
?>

<h4><?=$course->course_code . ' ' . $course->course_name?></h4>
<h4><?=$model->lecture->courseOffered->semester->longFormat()?></h4>

<br />
<h4>Record of Student’s Medical Checkup/ Class Exemption</h4>
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
  <th width="30%">Student</th>
  <th width="20%">Date</th>
  <th>Upload File</th>
  </tr>
</thead>

<tbody>
	<?php 
	$applicable = false;
	if($files){
		$i=1;
		foreach($files as $x=>$file){
			if($file->ex_date == '0000-00-00'){
				$file->ex_date = date('Y-m-d');
			}
			$file->scenario = 'saveall';
			$file->file_controller = 'tutorial-exempt-file';
			?>
			<tr>
			<td><?=$i?>. </td>
			<td>
			<?=Html::activeHiddenInput($file, "[{$x}]id");?>
			<?=Html::activeHiddenInput($model, "id");?>
			
			
	
			
			<?php 

			echo $form->field($file, "[{$x}]matric_no")->widget(Select2::classname(), [
				'data' => ArrayHelper::map($model->lecture->students, 'matric_no', 'matricAndName'),
				'language' => 'en',
				'options' => ['multiple' => false,'placeholder' => 'Select a student ...'],
				'pluginOptions' => [
					'allowClear' => true
				],
			])->label(false);

			?>

			
			
			
			</td>
			<td>
			<?=$form->field($file, "[{$x}]ex_date")
			->label(false)
			->widget(DatePicker::classname(), [
			    'removeButton' => false,
			    'pluginOptions' => [
			        'autoclose'=>true,
			        'format' => 'yyyy-mm-dd',
			        'todayHighlight' => true,
			        
			    ],
			]);
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


   
</div></div> 

<?php 
$check_na = $model->na_class_exempt == 1 ? 'checked' : ''; 
$check_complete = $model->prg_class_exempt == 1 ? 'checked' : ''; 
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