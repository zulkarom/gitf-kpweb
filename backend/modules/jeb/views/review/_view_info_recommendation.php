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
				'attribute' => 'review_at',
				'label' => 'Review Time'
			],
			[
				'label' => 'Status',
				'format' => 'html',
				'value' => function($model){
					return $model->wfLabelBack;
				}
			],
			[

				'label' => 'Manuscript File',
				'format' => 'raw',
				'value' => function($model){
					return '<a href="'. Url::to(['review/download-review-file', 'attr' => 'review', 'id' => $model->id]) .'" target="_blank"><i class="fa fa-download"></i> FILE</a>';
					
				}
			],
			

        ],
    ]) ?>

</div>
</div>
</div>

