<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\modules\erpd\models\Publication */

$this->title = 'View Publication';
$this->params['breadcrumbs'][] = ['label' => 'Publications', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Upload';

$model->file_controller = 'publication';

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
			[
				'label' => 'Publication File',
				'format' => 'raw',
				'value' => function($model){
					return Html::a('<span class="glyphicon glyphicon-download-alt"></span> File',['publication/download-file', 'attr'=>'pubupload', 'id' => $model->id], ['target' => '_blank']);
				}
			]
			
			
			

        ],
    ]) ?>

</div>
</div>
</div>





<?=Html::a('<span class="glyphicon glyphicon-arrow-left"></span> Back to Publication List', ['/erpd/publication'],['class'=>'btn btn-default'])?>




