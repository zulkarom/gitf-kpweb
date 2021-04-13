<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use common\models\UploadFile;

/* @var $this yii\web\View */
/* @var $model backend\modules\courseFiles\models\Material */

$this->title = $model->material_name;
$this->params['breadcrumbs'][] = ['label' => 'Materials', 'url' => ['index', 'course' => $model->course_id]];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="material-view">



<h4><?=$model->course->course_code . ' ' . $model->course->course_name?></h4>
<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="material-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'material_name')->textInput(['maxlength' => true]) ?>
	
	<div class="row">
<div class="col-md-6"><?= $form->field($model, 'mt_type')->dropDownList([1=> 'For Course File (pdf only)', 2 => 'Others (pdf,doc,docx,ppt,pptx,txt)'], ['prompt' => 'Please Select']) ?></div>

<div class="col-md-6"><?= $form->field($model, 'status')->dropDownList([0=> 'Draft', 10 => 'Submit'], ['prompt' => 'Please Select']) ?>
</div>

</div>
	
	
	
	


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>

<div class="box">
<div class="box-header">
<h3 class="box-title">List of Teaching Materials</h3>
</div>
<div class="box-body">

  <table class="table table-striped table-hover">
  <thead>
  <tr>
  <th width="5%">#</th>
  <th width="50%">Document Name</th>
  <th>Uploaded Files</th>
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
			<?=$item->item_name?>
			
			</td>
				<td><?php 
				
				if($item->item_file){
					echo Html::a('<span class="glyphicon glyphicon-download-alt"></span> Download', ['download-file', 'attr'=> 'item', 'id' => $item->id] , ['class' => 'btn btn-sm btn-danger', 'target' => '_blank']);
				}else{
					echo 'No File';
				}
				
				
				
				?></td>
			</tr>
			<?php
		$i++;
		}
	}
	
	?>
</tbody>
</table>


</div>
</div>






</div>
