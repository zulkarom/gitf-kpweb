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
			'ktp_title:ntext',
			[
				'label' => 'Members',
				'format' => 'html',
				'value' => function($model){
					return $model->stringMembers();
				}
				
			],
			'date_start:date',
			'date_end:date',
			'ktp_source',
			'ktp_research',
			'ktp_community',
			'ktp_description:ntext',
			'ktp_amount:currency',

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



