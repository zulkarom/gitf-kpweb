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
			'awd_name:ntext',
			'awd_by:ntext',
			'levelName',
			'awd_type',
			'awd_date:date',
			

			[
				'attribute' => 'status',
				'format' => 'html',
				'value' => function($model){
					return $model->showStatus();
				}
				
			],
			
			[
				'label' => 'Tagged Staff',
				'format' => 'html',
				'value' => function($model){
					return $model->tagStaffNames;
				}
			],

			
			
			
			

        ],
    ]) ?>

</div>
</div>
</div>



