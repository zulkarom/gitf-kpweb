<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;

?>
 
<div class="box">
<div class="box-header">
<i class="fa fa-asterisk"></i>
<h3 class="box-title">Pre-Evaluation Note</h3>

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
				'attribute' => 'pre_evaluate_by',
				'value' => function($model){
					return $model->preEvaluateBy->fullname;
				}
			],
			'pre_evaluate_note',
			[
				'attribute' => 'review_file',
				'format' => 'raw',
				'value' => function($model){
					if($model->review_file){
						return '<a href="'. Url::to(['submission/download', 'attr' => 'review', 'id' => $model->id]) .'" target="_blank"><i class="fa fa-download"></i> REVIEW FILE</a>';
					}else{
						return 'No File';
					}
					
				}
			],
			

        ],
    ]) ?>

</div>
</div>

