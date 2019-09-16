<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;

?>
 
<div class="box">
<div class="box-header">
<i class="fa fa-asterisk"></i>
<h3 class="box-title">Proofread File</h3>

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
				'attribute' => 'proofread_file',
				'format' => 'raw',
				'value' => function($model){
					if($model->proofread_file){
						return '<a href="'. Url::to(['editing/download', 'attr' => 'proofread', 'id' => $model->id]) .'" target="_blank"><i class="fa fa-download"></i> PROOFREAD FILE</a>';
					}else{
						return 'No File';
					}
					
				}
			],
			'proofread_note'

        ],
    ]) ?>

</div>
</div>

