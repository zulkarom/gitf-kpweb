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
			'msp_body:ntext',
			'msp_type:ntext',
			'date_start:date',
			'date_end:date',
			[
				'attribute' => 'msp_level',
				'value' => function($model){
					return $model->levelName;
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
				'label' => 'Membership File',
				'format' => 'raw',
				'value' => function($model){
					return Html::a('<span class="glyphicon glyphicon-download-alt"></span> File',['membership/download-file', 'attr'=>'msp', 'id' => $model->id], ['target' => '_blank']);
				}
			]

			
			
			
			

        ],
    ]) ?>

</div>
</div>
</div>



