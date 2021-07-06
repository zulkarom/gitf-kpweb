<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use backend\modules\conference\models\ReviewForm;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\conference\models\ConfPaper */

$this->title = $model->pap_title;
$this->params['breadcrumbs'][] = ['label' => 'Conf Papers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="conf-paper-view">

<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title">View Rejected Paper</h3>
							<p class="panel-subtitle"><?=$this->title?></p>
						</div>
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
			'reject_note'
  
        ],
    ]) ?></div>
</div>


<?php if($review){ 
    ?>
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
	
	
	if($review->reviewed_file){
	    echo '<tr>
		<td> </td>
		<td><a href="'. Url::to(['paper/download-reviewed-file', 'id' => $review->id, 'attr' => 'reviewed']) .'" target="_blank" class="btn btn-primary btn-xs"> <span class="glyphicon glyphicon-download-alt"></span> Reviewed File</a></td>
    
		<td> </td>
	</tr>';
	}
	
	?>
</tbody>
</table>

</div>
</div>

<?php } ?>
