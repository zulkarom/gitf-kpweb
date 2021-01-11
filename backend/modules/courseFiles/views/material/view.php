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

    <p>
        <?= Html::a('Update Teaching Materials', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="box">
<div class="box-header"></div>
<div class="box-body"><?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'material_name',
			'course.codeCourseString',
            'createdBy.fullname',
            'created_at:datetime',
			'updated_at:datetime'
        ],
    ]) ?></div>
</div>

<div class="box">
<div class="box-header">
<h3 class="box-title">Teaching Materials for Course File (.pdf)</h3>
</div>
<div class="box-body">

  <table class="table table-striped table-hover">
  <thead>
  <tr>
  <th>#</th>
  <th width="30%">File Name</th>
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
					echo Html::a('<span class="glyphicon glyphicon-download-alt"></span> Download', ['download', 'attr'=> 'item', 'id' => $item->id] , ['class' => 'btn btn-sm btn-warning', 'target' => '_blank']);
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
