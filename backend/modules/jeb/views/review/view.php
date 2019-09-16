<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use common\models\Todo;


/* @var $this yii\web\View */
/* @var $model common\models\Application */

$this->title = 'Submission Details';//$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Submission', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$status = $model->wfStatus;

if($status == 'pre-evaluate'){
	$file = [
				'attribute' => 'submission_file',
				'format' => 'raw',
				'value' => function($model){
					return '<a href="'. Url::to(['submission/download', 'attr' => 'submission', 'id' => $model->id]) .'" target="_blank"><i class="fa fa-download"></i> FILE</a>';
				}
			];
}else{
	$file = [
				'attribute' => 'review_file',
				'format' => 'raw',
				'value' => function($model){
					return '<a href="'. Url::to(['submission/download', 'attr' => 'review', 'id' => $model->id]) .'" target="_blank"><i class="fa fa-download"></i> FILE</a>';
				}
			];
}


?>
<div class="box">
<div class="box-header">

</div>
<div class="box-body"><div class="application-view">

<style>
table.detail-view th {
    width:15%;
}
</style>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            
			'title:ntext',
			[
				'label' => 'Authors',
				'format' => 'html',
				'value' => function($model){
					return $model->authors;
				}
			],
			
			[
				'label' => 'Scope',
				'format' => 'html',
				'value' => function($model){
					return $model->scope->scope_name;
				}
			],
			'abstract:ntext',
			'keyword',
			[
				'attribute' => 'pre_evaluate_at',
				'label' => 'Submit Time'
			],
			[
				'label' => 'Status',
				'format' => 'html',
				'value' => function($model){
					return $model->wfLabelBack;
				}
			],
			$file,
			

        ],
    ]) ?>

</div>
</div>
</div>


<?php 
if($status == 'pre-evaluate' && Todo::can('jeb-managing-editor')){
	?>
	<div class="form-group"><label><input type="radio" checked name="action" value="1" /> Assign Associate Editor </label>      <label><input type="radio" name="action" value="2" /> Return to Author(s) </label></div>
	<?php
	echo $this->render('_form_assign_associate', [
			'model' => $model,
	]);
}
?>

<?php 
if($status == 'assign-reviewer' && Todo::can('jeb-associate-editor')){

	echo $this->render('_form_assign_reviewer', [
			'model' => $model,
			'reviewers' => $reviewers
	]);
}
?>

<?php 
if($status == 'review' && Todo::can('jeb-managing-editor')){

	echo $this->render('_view_report', [
			'model' => $model,
			'reviewers' => $reviewers
	]);
}
?>



