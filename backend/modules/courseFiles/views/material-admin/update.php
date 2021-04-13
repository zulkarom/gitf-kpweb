<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\UploadFile;

/* @var $this yii\web\View */
/* @var $model backend\modules\courseFiles\models\Material */

$this->title = 'Update: ' . $model->material_name;
$this->params['breadcrumbs'][] = ['label' => 'Materials', 'url' => ['index', 'course' => $model->course_id]];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="material-update">
<h4><?=$course->course_code . ' ' . $course->course_name?></h4>

<div class="form-group"><?= Html::a('Back to View', ['view', 'id' => $model->id], ['class' => 'btn btn-info']) ?></div>

<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="material-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'material_name')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($model, 'mt_type')->dropDownList([1=> 'For Course File (pdf only)', 2 => 'Others (pdf,doc,docx,ppt,pptx,txt)'], ['prompt' => 'Please Select']) ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
	
<div class="box">
<div class="box-header">
<h3 class="box-title">Teaching Materials</h3>
</div>
<div class="box-body">

  <table class="table table-striped table-hover">
  <thead>
  <tr>
  <th>#</th>
  <th width="30%">Document Name</th>
  <th>Upload File</th>
  </tr>
</thead>
<tbody>
	<?php 
	if($materialItems){
		$i = 1;
		foreach($materialItems as $x => $item){
			$item->scenario = 'saveall';
			$item->file_controller = 'material';
			?>
			<tr>
			<td><?=$i?>. </td>
			<td>
			<?=Html::activeHiddenInput($item, "[{$x}]id");?>
			<?=Html::activeHiddenInput($model, "id");?>
			<?= $form->field($item, "[{$x}]item_name")->label(false) ?>
			
			</td>
				<td><?=UploadFile::fileInput($item, 'item', false, true, 'material-item')?></td>
			</tr>
			<?php
		$i++;
		}
	}
	
	?>
</tbody>
</table>

 <div class="form-group">
        <?= Html::submitButton('Save Materials', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>

</div>
