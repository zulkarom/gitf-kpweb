<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\widgets\ActiveForm;
use richardfan\widget\JSRegister;
use kartik\select2\Select2;
use backend\modules\conference\models\ReviewForm;
use backend\modules\staff\models\Staff;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\modules\conference\models\ConfPaper */

$this->title = 'View Full Paper';
$this->params['breadcrumbs'][] = ['label' => 'Conf Papers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="conf-paper-view">

<div class="panel panel-headline">
		
						<div class="panel-body">
			<style>
table.detail-view th {
    width:17%;
}
</style>

			
			<?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
				'attribute' => 'user_id',
				'label' => 'Submitted By',
				'value' => function($model){
					return $model->user->fullname;
				}
			],
			[
				'attribute' => 'created_at',
				'label' => 'Submitted Time',
				'format' => 'datetime'
			]
			,
            'pap_title:ntext',
			[
				'label' => 'Authors',
				'format' => 'html',
				'value' => function($model){
					return $model->authorString();
				}
				
			],
            'pap_abstract:ntext',
			'keyword:ntext',
			[
				'attribute' => 'myrole',
				'label' => 'Role Selection',
				'value' => function($model){
					if($model->authorRole){
						return $model->authorRole->fee_name;
					}
					
				}
				
			],
			[
				'attribute' => 'paper_file',
				'label' => 'Uploaded Full Paper',
				'format' => 'raw',
				'value' => function($model){
					return Html::a('<span class="glyphicon glyphicon-download-alt"></span> DOWNLOAD FILE', ['paper/download-file', 'id' => $model->id, 'attr' => 'paper'], ['class' => 'btn btn-default','target' => '_blank']);
				}
			],
			[
			    'label' => 'Reviewer',
			    'value' => function($model){
			    return $model->reviewer->fullname;
			    }
			    ]
  
        ],
    ]) ?></div>
</div>

 <div class="box">
<div class="box-header">
<h4>Review</h4>
</div>
<div class="box-body">


<br />
<table class="table table-striped table-hover">
<thead>
<tr>
	<th width="1%">#</th>
	<th width="35%">Review Items</th>
	<th>Remark</th>
</tr>
</thead>
<tbody>
	
	<?php 
	
	$i =1;
	foreach(ReviewForm::find()->all() as $f){
	    $attr = 'q_'. $i . '_note';
	    echo '<tr>
		<td>'.$i.'. </td>
		<td>'.$f->form_quest.'</td>
	
		<td> ' . $review->$attr .' </td>
	</tr>';
	$i++;
	}
	
	?>
</tbody>
</table>

</div>
</div>


