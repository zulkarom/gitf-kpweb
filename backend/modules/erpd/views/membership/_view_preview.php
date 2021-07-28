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
			
			[
				'attribute' => 'date_end',
				'value' => function($model){
					if($model->date_end == null){
						return 'No End';
					}else{
						return date('d M Y', strtotime($model->date_end));
					}
				}
				
			],
			
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

			
			
			
			

        ],
    ]) ?>

</div>
</div>
</div>



