<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\conference\models\ConfPaper */

$this->title = $model->pap_title;
$this->params['breadcrumbs'][] = ['label' => 'Papers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="conf-paper-view">


<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title"><?=$this->title?></h3>
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
					return Html::a('DOWNLOAD', ['paper/download-file', 'id' => $model->id, 'attr' => 'paper'], ['target' => '_blank']);
				}
			],
			[
				'label' => 'Acceptance Letter',
				'format' => 'raw',
				'value' => function($model){
					return Html::a('DOWNLOAD', ['paper/accept-letter-pdf', 'id' => $model->id], ['target' => '_blank']);
				}
				
			],
			[
				'label' => 'Invoice',
				'format' => 'raw',
				'value' => function($model){
					return Html::a('DOWNLOAD', ['paper/invoice-pdf',   'id' => $model->id], ['target' => '_blank']);
				}
				
			],
  
        ],
    ]) ?></div>
</div>



</div>

