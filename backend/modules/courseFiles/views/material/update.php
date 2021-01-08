<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\UploadFile;

/* @var $this yii\web\View */
/* @var $model backend\modules\courseFiles\models\Material */

$this->title = 'Update: ' . $model->material_name;
$this->params['breadcrumbs'][] = ['label' => 'Materials', 'url' => ['index']];
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
<h3 class="box-title">List of Materials</h3>
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

  <table class="table table-striped table-hover">

<tbody>
	<?php 
	if($model->items){
		foreach($model->items as $item){
			$item->file_controller = 'material';
			?>
			<tr>
				<td><?=UploadFile::fileInput($item, 'item', false, true, 'material-item')?></td>
			</tr>
			<?php
		}
	}
	
	?>
</tbody>
</table>



</div>
</div>

</div>
