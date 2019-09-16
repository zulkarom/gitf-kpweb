<?php

use yii\helpers\Url;
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
            [
				'attribute' => 'id',
				'label' => 'Manuscript No.',
				'value' => function($model){
					return $model->manuscriptNo();
				}
			],
			'title:ntext',
			
			
			[
				'label' => 'Scope',
				'format' => 'html',
				'value' => function($model){
					return $model->scope->scope_name;
				}
			],
			'abstract:ntext',
			'keyword',
			[
				'attribute' => 'recommend_at',
				'label' => 'Recommendation Time'
			],
			[
				'label' => 'Status',
				'format' => 'html',
				'value' => function($model){
					return $model->wfLabelBack;
				}
			],
			[

				'label' => 'Review File',
				'format' => 'raw',
				'value' => function($model){
					if($model->review_file){
						return '<a href="'. Url::to(['review/download-review-file', 'attr' => 'review', 'id' => $model->id]) .'" target="_blank"><i class="fa fa-download"></i> FILE</a>';	
					}else{
						return '<a href="'. Url::to(['submission/download', 'attr' => 'review', 'id' => $model->id]) .'" target="_blank"><i class="fa fa-download"></i> FILE</a>';
					}
					
				}
			]
			

        ],
    ]) ?>

</div>
</div>
</div>

