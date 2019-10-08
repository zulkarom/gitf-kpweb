<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\erpd\models\ConsultationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'All Consultations';
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
            'csl_title',
			'csl_funder',
			
			[
				'attribute' => 'csl_amount',
				'label' => 'Value of Sponsorship',
				'value' => function($model){
					return $model->csl_amount;
				}
				
			],
			
			[
				'attribute' => 'csl_level',
				'value' => function($model){
					return $model->levelName;
				}
			]
            ,
			'date_start:date',
			'date_end:date',
			
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
<div class="consultation-index">

<div class="form-group"><?=ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $exportColumns,
	'filename' => 'CONSULTATION_DATA_' . date('Y-m-d'),
	'onRenderSheet'=>function($sheet, $grid){
		$sheet->getStyle('A2:'.$sheet->getHighestColumn().$sheet->getHighestRow())
		->getAlignment()->setWrapText(true);
		
	},
	'exportConfig' => [
        ExportMenu::FORMAT_PDF => false,
		ExportMenu::FORMAT_EXCEL_X => false,
    ],
]);?></div>

   <div class="box">
<div class="box-header"></div>
<div class="box-body"> <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
		'export' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
				'label' => '',
				'format' => 'raw',
				'contentOptions' => [ 'style' => 'width: 1%;' ],
				'value' => function($model){
					
					return '<a href="'.Url::to(['/erpd/consultation/download-file', 'attr' => 'csl', 'id' => $model->id]).'" target="_blank"><i class="fa fa-file-pdf-o"></i></a>';
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
            'csl_title',
			
			[
				'attribute' => 'csl_level',
				'filter' => Html::activeDropDownList($searchModel, 'csl_level', $searchModel->listLevel(),['class'=> 'form-control','prompt' => 'All']),
				'value' => function($model){
					return $model->levelName;
				}
			]
            ,
            [
				'attribute' => 'duration',
				'filter' => Html::activeDropDownList($searchModel, 'duration', $searchModel->listYears(),['class'=> 'form-control','prompt' => 'All']),
				'label' => 'Duration',
				'format' => 'html',
				'value' => function($model){
					return date('d/m/Y', strtotime($model->date_start)) . '<br />' . date('d/m/Y', strtotime($model->date_end));
				}
				
			],
			
			[
				'attribute' => 'status',
                'format' => 'html',
				'filter' => Html::activeDropDownList($searchModel, 'status', $searchModel->statusListAdmin(),['class'=> 'form-control','prompt' => 'All']),
				'value' => function($model){
					return $model->showStatus();
				}
			]

            ,

            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 8.7%'],
                'template' => '{update}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
						if($model->status < 50){
							return Html::a('<span class="glyphicon glyphicon-eye-open"></span> VERIFY',['/erpd/admin/view-consultation', 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
						}else{
							return Html::a('<span class="glyphicon glyphicon-search"></span> VIEW',['/erpd/admin/view-consultation', 'id' => $model->id],['class'=>'btn btn-default btn-sm']);
						}
                        
                    }
                ],
            
            ],

        ],
    ]); ?></div>
</div>

</div>
