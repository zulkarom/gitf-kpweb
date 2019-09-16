<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\DetailView;

?>
 
<div class="box">
<div class="box-header">
<i class="fa fa-asterisk"></i>
<h3 class="box-title">Author's Final Revision</h3>

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
				'attribute' => 'finalise_option',
				'label' => 'Author\'s Final View',
				'value' => function($model){
					return $model->finaliseOption;
				}
			]
            ,
			'finalise_note',
			[
				'attribute' => 'finalise_file',
				'format' => 'raw',
				'value' => function($model){
					if($model->finalise_file){
						return '<a href="'. Url::to(['editing/download', 'attr' => 'finalise', 'id' => $model->id]) .'" target="_blank"><i class="fa fa-download"></i> FINAL FILE</a>';
					}else{
						return 'No File';
					}
					
				}
			],
			

        ],
    ]) ?>

</div>
</div>

