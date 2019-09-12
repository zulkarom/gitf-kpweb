<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\erpd\models\AwardSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'All Awards';
$this->params['breadcrumbs'][] = $this->title;

$exportColumns = [
		['class' => 'yii\grid\SerialColumn'],
		['attribute' => 'staff_search',
			'label' => 'Staff',
			'value' => function($model){
				if($model->staff){
					return $model->staff->user->fullname . ' ('.$model->staff->staff_no .')';
				}
				
			}
			
		],
		'awd_name',
		'awd_by',
		[
			'attribute' => 'awd_level',
			'value' => function($model){
				return $model->levelName;
			}
		]
		,
		[
			'attribute' => 'awd_date',
			'format' => 'date',
		],
		[
			'attribute' => 'status',
			'format' => 'html',
			'value' => function($model){
				return $model->showStatus();
			}
		],
		'created_at',
		'modified_at',
		'reviewed_at'

];


?>
<div class="award-index">

<div class="form-group"><?=ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $exportColumns,
	'filename' => 'AWARD_DATA_' . date('Y-m-d'),
	'onRenderSheet'=>function($sheet, $grid){
		$sheet->getStyle('A2:'.$sheet->getHighestColumn().$sheet->getHighestRow())
		->getAlignment()->setWrapText(true);
		
	},
	'exportConfig' => [
    \kartik\export\ExportMenu::FORMAT_PDF => [
        'pdfConfig' => [
            'orientation' => 'L',
        ],
    ],
],
]);?></div>

    <div class="box">
<div class="box-header"></div>
<div class="box-body"><?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
				'label' => '',
				'format' => 'raw',
				'contentOptions' => [ 'style' => 'width: 1%;' ],
				'value' => function($model){
					
					return '<a href="'.Url::to(['download-file', 'attr' => 'awd', 'id' => $model->id]).'" target="_blank"><i class="fa fa-file-pdf-o"></i></a>';
				}
				
			],
			[
				'attribute' => 'staff_search',
				'label' => 'Staff',
				'value' => function($model){
					if($model->staff){
						return $model->staff->user->fullname;
					}
					
				}
				
			],
            'awd_name',
			[
				'attribute' => 'awd_level',
				'filter' => Html::activeDropDownList($searchModel, 'awd_level', $searchModel->listLevel(),['class'=> 'form-control','prompt' => 'All']),
				'value' => function($model){
					return $model->levelName;
				}
			]
            ,
			[
				'attribute' => 'awd_date',
				'filter' => Html::activeDropDownList($searchModel, 'duration', $searchModel->listYears(),['class'=> 'form-control','prompt' => 'All']),
				'format' => 'date',
			],
			[
				'attribute' => 'status',
                'format' => 'html',
				'filter' => Html::activeDropDownList($searchModel, 'status', $searchModel->statusListAdmin(),['class'=> 'form-control','prompt' => 'All']),
				'value' => function($model){
					return $model->showStatus();
				}
			],

            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 8.7%'],
                'template' => '{update}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
						if($model->status < 50){
							return Html::a('<span class="glyphicon glyphicon-eye-open"></span> VERIFY',['/erpd/award/view-verify', 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
						}else{
							return Html::a('<span class="glyphicon glyphicon-pencil"></span> VIEW',['/erpd/award/view-verify', 'id' => $model->id],['class'=>'btn btn-default btn-sm']);
						}
                        
                    }
                ],
            
            ],

        ],
    ]); ?></div>
</div>

</div>
