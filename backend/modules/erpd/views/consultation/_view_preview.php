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
			'csl_title:ntext',
			'csl_funder:ntext',
			'csl_amount:currency',
			'levelName',
			'date_start:date',
			'date_end:date',
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



