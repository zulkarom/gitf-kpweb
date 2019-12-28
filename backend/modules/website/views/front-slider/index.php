<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use oonne\sortablegrid\SortableGridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Front Sliders';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="front-slider-index">


    <p>
        <?= Html::a('New Slide', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <div class="box">
<div class="box-header"></div>
<div class="box-body">

<?= SortableGridView::widget([
        'dataProvider' => $dataProvider,
		'sortableAction' => ['/website/front-slider/sort'],
        'columns' => [

			
			[
				'label' => '',
				'format' => 'html',
				'value' => function(){
					return '<span class="glyphicon glyphicon-move"></span>';
				},
				'contentOptions' => ['class' => 'sortable-handle'],
			]
			,
            [
				'label' => 'Information',
				'format' => 'html',
				'value' => function($model){
						$lbl = 'NO';
						$col = 'danger';
					if($model->is_publish == 1){
						$lbl = 'YES';
						$col = 'success';
					}
					$pub = '<span class="label label-'.$col.'">'.$lbl.'</span>';
					return '
					<div>Name: ' . $model->slide_name . '</div>
					<div>Publish: ' . $pub . '</div>
		
					<div>Created by: ' . $model->createdBy->fullname . '</div>
					<div>Created at: ' . date('d.m.Y', strtotime($model->created_at)) . '</div>
					<div>Updated at: ' . date('d.m.Y', strtotime($model->updated_at)) . '</div>
					';
				}
			
			],
			[
				'label' => 'Image',
				'format' => 'html',
				'value' => function($model){
					if($model->image_file){
						return '<img src="'.Url::to(['/website/front-slider/download-file', 'attr' => 'image','id' => $model->id]).'" width="300px" />';
					}else{
						return 'NO IMAGE!';
					}
					
				}
			],
            
['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 13%'],
                'template' => '<div class="form-group">{update}</div><div class="form-group">{delete}</div>',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span> Update',['/website/front-slider/update', 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
                    },
                    'delete'=>function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span> Delete', ['/website/front-slider/delete', 'id' => $model->id], [
            'class' => 'btn btn-danger btn-sm',
            'data' => [
                'confirm' => 'Are you sure you want to delete this slide?',
                'method' => 'post',
            ],
        ]) 
;
                    }
                ],
            
            ],


        ],
    ]); ?></div>
</div>

</div>
