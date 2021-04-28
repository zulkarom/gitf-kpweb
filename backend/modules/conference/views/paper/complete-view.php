<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
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
							<h3 class="panel-title">View Complete Paper</h3>
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
					return Html::a('<i class="fa fa-download"></i> DOWNLOAD FULL PAPER', ['paper/download-file', 'id' => $model->id, 'attr' => 'paper'], ['class'=> 'btn btn-default btn-sm', 'target' => '_blank']);
				}
			],
			[
				'label' => 'Invoice',
				'format' => 'raw',
				'value' => function($model){
					if($model->payment_file){
						return '<a href="'.Url::to(['paper/invoice-pdf', 'id' => $model->id]).'" target="_blank" class="btn btn-default btn-sm"><i class="fa fa-download"></i> DOWNLOAD INVOICE</a>';
					}else{
						return 'NO FILE';
					}
					
				}
				
			],
			[
				'label' => 'Invoice Amount',
				'value' => function($model){
					return $model->invoice_currency . ' ' . number_format($model->invoice_amount, 2);
					
				}
				
			],
			'payment_at:datetime',
			'payment_info:ntext',
			[
				'attribute' => 'payment_file',
				'format' => 'raw',
				'value' => function($model){
					if($model->payment_file){
						return '<a href="'.Url::to(['paper/download-file', 'attr' => 'payment', 'id' => $model->id]).'" target="_blank" class="btn btn-default btn-sm"><i class="fa fa-download"></i> DOWNLOAD PAYMENT</a>';
					}else{
						return 'NO FILE';
					}
					
				}
				
			],
  
        ],
    ]) ?></div>
</div>

