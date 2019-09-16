<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
?>
 
<div class="box">
<div class="box-header">
<i class="fa fa-asterisk"></i>
<h3 class="box-title">Evaluation Report</h3>

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
				'label' => 'Evaluation By',
				'format' => 'html',
				'value' => function($model){
					return $model->evaluateBy->fullname;
				}
			],
			'evaluate_note:ntext',
			[
				'label' => 'Evaluation Option',
				'value' => function($model){
					return $model->evaluateOption;
				}
			],
			
			

        ],
    ]) ?>

</div>
</div>

