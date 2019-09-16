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
    width:25%;
}
</style>

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
				'attribute' => 'cameraready_file',
				'format' => 'raw',
				'value' => function($model){
					return '<a href="'. Url::to(['submission/download', 'attr' => 'cameraready', 'id' => $model->id]) .'" target="_blank"><i class="fa fa-download"></i> CAMERA READY FILE</a>';
				}
			],
			

        ],
    ]) ?>

</div>
</div>
</div>

