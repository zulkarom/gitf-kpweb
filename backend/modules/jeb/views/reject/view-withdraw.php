<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use common\models\Todo;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model common\models\Application */

$this->title = 'Withdrawal Request';//$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Withdrawal', 'url' => ['reject/withdraw']];
$this->params['breadcrumbs'][] = $this->title;


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
				'attribute' => 'submit_at',
				'label' => 'Submission Time',
				'format' => 'datetime'
				
			],
			[
				'label' => 'Status',
				'format' => 'html',
				'value' => function($model){
					return $model->wfLabelBack;
				}
			],
			[
				'attribute' => 'submission_file',
				'format' => 'raw',
				'value' => function($model){
					return '<a href="'. Url::to(['submission/download', 'attr' => 'submission', 'id' => $model->id]) .'" target="_blank"><i class="fa fa-download"></i> MANUSCRIPT FILE</a>';
				}
			],
			

        ],
    ]) ?>

</div>
</div>
</div>

<?php $form = ActiveForm::begin(); ?>

<div class="box">
<div class="box-header">
<i class="fa fa-asterisk"></i>
<h3 class="box-title">Withdrawal Note</h3>

</div>

<div class="box-body"> 
<style>
table.detail-view th {
    width:25%;
}
</style>

<?= DetailView::widget([
        'model' => $model,
        'attributes' => [

			[
				'label' => 'Withdrawal Note',
				'attribute' => 'withdraw_note'
				
			],
			[
				'label' => 'Withdrawal Time',
				'attribute' => 'withdraw_request_at',
				'format' => 'datetime'
				
			],
        ],
    ]) ?>

</div>
</div>

<div class="form-group">
	<?=$form->field($model, 'withdraw_at')->hiddenInput(['value' => time()])->label(false)?>
	
	
		
	<?=Html::submitButton('ALLOW WITHDRAWAL', ['class' => 'btn btn-danger', 'name' => 'wfaction', 'value' => 'allow', 'data' => [
                'confirm' => 'Are you sure to allow the manuscript to be withdrew?'
            ],
])?>

<?=Html::submitButton('CANCEL WITHDRAWAL', ['class' => 'btn btn-success', 'name' => 'wfaction', 'value' => 'goback', 'data' => [
                'confirm' => 'Are you sure to cancel the withdrawal and put the manuscript back to previous status?'
            ],
])?>

    </div>

<?php  ActiveForm::end(); 