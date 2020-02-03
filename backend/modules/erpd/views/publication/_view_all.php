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
			[
				'label' => 'Type of Publication',
				'value' => function($model){
					return $model->pubType->type_name;
				}
			],
			'pub_title:ntext',
			[
				'label' => 'Authors',
				'format' => 'html',
				'value' => function($model){
					return $model->stringAuthorsPlain();
				}
			],
			[
				'label' => 'Summary',
				'format' => 'html',
				'value' => function($model){
					return $model->showApaStyle();
				}
			],
			[
				'label' => 'Tagged Staff',
				'format' => 'html',
				'value' => function($model){
					return $model->tagStaffNames;
				}
			],
			'pub_index',
			[
				'label' => 'Status',
				'format' => 'html',
				'value' => function($model){
					return $model->showStatus();
				}
			],
			[
				'label' => 'Publication File',
				'format' => 'raw',
				'value' => function($model){
					return Html::a('<span class="glyphicon glyphicon-download-alt"></span> File',['publication/download-file', 'attr'=>'pubupload', 'id' => $model->id], ['target' => '_blank']);
				}
			],
			[
				'label' => 'Other File',
				'format' => 'raw',
				'value' => function($model){
					if($model->pubother_file){
						return Html::a('<span class="glyphicon glyphicon-download-alt"></span> File',['publication/download-file', 'attr'=>'pubother', 'id' => $model->id], ['target' => '_blank']);
					}else{
						return 'NONE';
					}
					
				}
			]
			
			
			

        ],
    ]) ?>

</div>
</div>
</div>