<?php

use yii\helpers\Url;
use yii\widgets\DetailView;

$status = $model->wfStatus;

if($status == 'pre-evaluate'){
	$file = [
				'attribute' => 'submission_file',
				'format' => 'raw',
				'value' => function($model){
					return '<a href="'. Url::to(['submission/download', 'attr' => 'submission', 'id' => $model->id]) .'" target="_blank"><i class="fa fa-download"></i> FILE</a>';
				}
			];
}else{
	$file = [

				'label' => 'Manuscript File',
				'format' => 'raw',
				'value' => function($model){
					if($model->review_file){
						return '<a href="'. Url::to(['review/download', 'attr' => 'review', 'id' => $model->id]) .'" target="_blank"><i class="fa fa-download"></i> FILE</a>';	
					}else{
						return '<a href="'. Url::to(['submission/download', 'attr' => 'review', 'id' => $model->id]) .'" target="_blank"><i class="fa fa-download"></i> FILE</a>';
					}
					
				}
			];
}


?>
<div class="box">
<div class="box-header">

</div>
<div class="box-body"><div class="application-view">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            
			'title:ntext',
			[
				'label' => 'Authors',
				'format' => 'html',
				'value' => function($model){
					return $model->authors;
				}
			],
			
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
				'attribute' => 'pre_evaluate_at',
				'label' => 'Submit Time'
			],
			[
				'label' => 'Status',
				'format' => 'html',
				'value' => function($model){
					return $model->wfLabelBack;
				}
			],
			$file,
			

        ],
    ]) ?>

</div>
</div>
</div>

