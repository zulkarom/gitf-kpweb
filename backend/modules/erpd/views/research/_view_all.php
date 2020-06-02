<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
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
			'res_title:ntext',
			[
				'label' => 'Researchers',
				'format' => 'html',
				'value' => function($model){
					return $model->stringResearchers();
				}
				
			],
			'date_start:date',
			'date_end:date',
			[
				'attribute' => 'res_grant',
				'value' => function($model){
					return $model->researchGrant->gra_abbr;
				}
				
			],
			'res_source',
			'res_amount:currency',
			[
				'attribute' => 'res_progress',
				'format' => 'html',
				'value' => function($model){
					return $model->showProgress();
				}
				
			],
			[
				'attribute' => 'status',
				'format' => 'html',
				'value' => function($model){
					return $model->showStatus();
				}
				
			],
			[
				'label' => 'Research File',
				'format' => 'raw',
				'value' => function($model){
					return Html::a('<span class="glyphicon glyphicon-download-alt"></span> File',['research/download-file', 'attr'=>'res', 'id' => $model->id], ['target' => '_blank']);
				}
			]

			
			
			
			

        ],
    ]) ?>

</div>
</div>
</div>


<?php 

if($model->userCanEdit()){
	 echo Html::a('<span class="glyphicon glyphicon-pencil"></span> Re-Update Research', ['/erpd/research/re-update', 'id' => $model->id],['class'=>'btn btn-warning']);
}

?>
