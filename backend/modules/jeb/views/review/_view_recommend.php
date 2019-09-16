<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
?>
 
<div class="box">
<div class="box-header">
<i class="fa fa-asterisk"></i>
<h3 class="box-title">Recommendation Report</h3>

</div>

<div class="box-body"> 
<style>
table.detail-view th {
    width:25%;
}
</style>

<?= DetailView::widget([
        'model' => $model,
        'attributes' => [

			[
				'label' => 'Recommendation By',
				'format' => 'html',
				'value' => function($model){
					return $model->recommedBy->fullname;
				}
			],
			'recommend_note:ntext',
			[
				'label' => 'Recommendation Option',
				'value' => function($model){
					return $model->recommendOption;
				}
			],
			
			

        ],
    ]) ?>

</div>
</div>

