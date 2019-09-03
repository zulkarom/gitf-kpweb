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

			
			
			
			

        ],
    ]) ?>

</div>
</div>
</div>



