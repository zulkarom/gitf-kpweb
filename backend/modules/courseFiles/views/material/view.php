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

    <div class="form-group">
<?= Html::a('List', ['index', 'course' => $model->course_id], ['class' => 'btn btn-info']) ?>
        <?php 
		
		if($model->status == 0){
			echo Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
			echo ' ';
			echo Html::a('Submit', ['submit', 'id' => $model->id, 'course' => $model->course_id], ['class' => 'btn btn-success', 'data' => [
                'confirm' => 'Are you sure to submit? You will no longer could update the teaching materials. '
            ]]);
			echo ' ';
			echo '<div class="pull-right">' . Html::a('Delete', ['delete', 'id' => $model->id], [
				'class' => 'btn btn-danger',
				'data' => [
					'confirm' => 'Are you sure you want to delete this item?',
					'method' => 'post',
				],
			]) . '</div>';
		}
		 ?>
    </div>
<style>
table.detail-view th {
    width:20%;
}
</style>

    <div class="box">
<div class="box-header"></div>
<div class="box-body"><?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'material_name',
			'typeDesc',
			'statusName:html',
			'course.codeCourseString',
            'createdBy.fullname',
            'created_at:datetime',
			'updated_at:datetime'
        ],
    ]) ?></div>
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
