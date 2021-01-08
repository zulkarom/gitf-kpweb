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


<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="material-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'material_name')->textInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
	
<div class="box">
<div class="box-header">
<h3 class="box-title">Teaching Materials for Course File (.pdf)</h3>
</div>
<div class="box-body">
<?php $form = ActiveForm::begin(); 
	
	$addMaterial->material_number = 1;
	echo $form->field($addMaterial, 'material_number', [
                    'template' => 'Add Materials: {input}',
                    'options' => [
						
                        'tag' => false, // Don't wrap with "form-group" div
                    ]])->textInput(['style' => 'width:50px', 'type' => 'number', 'class' => ''])->label(false);

	echo Html::submitButton('Go', ['class' => 'btn btn-sm btn-default']);
	ActiveForm::end(); ?>


<?php $form = ActiveForm::begin(); ?>
  <table class="table table-striped table-hover">
  <thead>
  <tr>
  <th>#</th>
  <th width="30%">File Name</th>
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
			<?=Html::activeHiddenInput($item, "[{$i}]id");?>
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
        <?= Html::submitButton('Save Materials (Course File)', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>

</div>
