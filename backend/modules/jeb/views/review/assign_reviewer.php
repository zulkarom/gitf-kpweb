<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use common\models\Todo;


/* @var $this yii\web\View */
/* @var $model common\models\Application */

$this->title = 'Reviewer Assignment';//$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Submission', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$status = $model->wfStatus;


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
            [
				'attribute' => 'id',
				'label' => 'Manuscript No.',
				'value' => function($model){
					return $model->manuscriptNo();
				}
			],
			'title:ntext',
			
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
				'label' => 'Submit Time',
				'format' => 'datetime'
			],
			[
				'label' => 'Status',
				'format' => 'html',
				'value' => function($model){
					return $model->wfLabelBack;
				}
			]
			

        ],
    ]) ?>

</div>
</div>
</div>

<?=$this->render('_view_pre_evaluate', [
			'model' => $model
	])?>


<?php 
if($status == 'assign-reviewer' && Todo::can('jeb-associate-editor')){
	?>

	<?php
	echo $this->render('_form_assign_reviewer', [
			'model' => $model,
			'reviewers' => $reviewers
	]);
}
?>

