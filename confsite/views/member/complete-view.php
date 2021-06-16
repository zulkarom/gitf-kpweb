<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use backend\modules\conference\models\UploadFile;

/* @var $this yii\web\View */
/* @var $model backend\modules\conference\models\ConfPaper */

$this->title = $model->pap_title;
$this->params['breadcrumbs'][] = ['label' => 'Papers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$model->file_controller = 'member';
?>
<div class="conf-paper-view">


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
			],
			[
				'attribute' => 'Status',
				'format' => 'html',
				'value' => function($model){
					return $model->paperStatus;
				}
				
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
				if($model->repaper_file){
				    return Html::a('DOWNLOAD', ['paper/download-file', 'id' => $model->id, 'attr' => 'repaper'], ['class' => 'btn btn-info btn-sm', 'target' => '_blank']);
				}else{
				    return Html::a('DOWNLOAD', ['paper/download-file', 'id' => $model->id, 'attr' => 'paper'], ['class' => 'btn btn-info btn-sm', 'target' => '_blank']);
				}
					
				}
			],
/* 			[
				'label' => 'Acceptance Letter',
				'format' => 'raw',
				'value' => function($model){
					return Html::a('DOWNLOAD', ['member/accept-letter-pdf', 'id' => $model->id], ['class' => 'btn btn-info btn-sm','target' => '_blank']);
				}
				
			],
			[
				'label' => 'Invoice',
				'format' => 'raw',
				'value' => function($model){
					return Html::a('DOWNLOAD', ['member/invoice-pdf', 'id' => $model->id], ['class' => 'btn btn-info btn-sm','target' => '_blank']);
				}
				
			],
			
			[
				'label' => 'Receipt',
				'format' => 'raw',
				'value' => function($model){
					return Html::a('DOWNLOAD RECEIPT', ['member/receipt-pdf', 'id' => $model->id], ['class' => 'btn btn-success btn-sm','target' => '_blank']);
				}
				
			], */
  
        ],
    ]) ?>



</div>
