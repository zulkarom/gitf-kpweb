<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\website\models\EventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Events';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-index">

    <p>
        <?= Html::a('Create Event', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

<div class="box">
<div class="box-header"></div>
<div class="box-body">    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
		'options' => [ 'style' => 'table-layout:fixed;' ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

    
  
			[
                'attribute' => 'name',
                'format' => 'ntext',
                'contentOptions' => [ 'style' => 'width: 50%;' ],
            ],
			'date_start:date',
			
			[
				'attribute' => 'publish_promo',
				'filter' => Html::activeDropDownList($searchModel, 'publish_promo', [1=>'YES', 0 => 'NO'],['class'=> 'form-control','prompt' => 'All']),
				'format' => 'html',
				'value' => function($model){
					$val = $model->publish_promo;
					if($val == 1){
						return '<span class="label label-success">YES</span>';
					}else{
						return '<span class="label label-danger">NO</span>';
					}
				}
				
			],
			
			[
				'attribute' => 'publish_report',
				'filter' => Html::activeDropDownList($searchModel, 'publish_report', [1=>'YES', 0 => 'NO'],['class'=> 'form-control','prompt' => 'All']),
				'format' => 'html',
				'value' => function($model){
					$val = $model->publish_report;
					if($val == 1){
						return '<span class="label label-success">YES</span>';
					}else{
						return '<span class="label label-danger">NO</span>';
					}
				}
				
			],

           ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 10%'],
                'template' => '{update} {delete}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>',['/website/event/update/', 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
                    },
					'delete'=>function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>',['/website/event/delete-event/', 'id' => $model->id],['class'=>'btn btn-danger btn-sm', 'data' => [
                'confirm' => 'Are you sure to delete this event?'
            ],
]);
                    }
                ],
            
            ],

        ],
    ]); ?></div>
</div>

</div>
