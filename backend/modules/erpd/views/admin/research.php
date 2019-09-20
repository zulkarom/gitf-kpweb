<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\erpd\models\ResearchSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'All Researches';
$this->params['breadcrumbs'][] = $this->title;

$exportColumns = [
    ['class' => 'yii\grid\SerialColumn'],
	'res_title',
	[
		'label' => 'Researchers',
		'value' => function($model){
			return $model->plainResearchers();
		}
	],
	'date_start:date',
	'date_end:date',
	[
		'attribute' => 'res_grant',
		'label' => 'Grant',
		'value' => function($model){
			if($model->researchGrant){
				return $model->researchGrant->gra_abbr;
			}
			
		}
		
	],
	'res_source',
	'res_amount',
	
	[
		'attribute' => 'res_progress',
		'value' => function($model){
			return $model->strProgress();
		}
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

$colums = [
            ['class' => 'yii\grid\SerialColumn'],
			[
				'label' => '',
				'format' => 'raw',
				'contentOptions' => [ 'style' => 'width: 1%;' ],
				'value' => function($model){
					
					return '<a href="'.Url::to(['erpd/research/download-file', 'attr' => 'res', 'id' => $model->id]).'" target="_blank"><i class="fa fa-file-pdf-o"></i></a>';
				}
				
			],
			[
                'attribute' => 'res_title',
				'label' => 'Title',
                'format' => 'html',
                'contentOptions' => [ 'style' => 'width: 50%;' ],
				'value' => function($model){
					return '<i>' . $model->res_title . '<br />' . '<span class="fa fa-user"></span> ' . $model->leader . '</i>';
				}
            ],
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
				'attribute' => 'res_grant',
				'filter' => Html::activeDropDownList($searchModel, 'res_grant', $searchModel->listGrants(),['class'=> 'form-control','prompt' => 'All']),
				'label' => 'Grant',
				'value' => function($model){
					if($model->researchGrant){
						return $model->researchGrant->gra_abbr . ' RM' . number_format($model->res_amount,2);
					}
					
				}
				
			],
			[
				'attribute' => 'res_progress',
				'filter' => Html::activeDropDownList($searchModel, 'res_grant', $searchModel->progressArr(),['class'=> 'form-control','prompt' => 'All']),
				'format' => 'html',
				'value' => function($model){
					return $model->showProgress();
				}
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
							return Html::a('<span class="glyphicon glyphicon-eye-open"></span> VERIFY',['/erpd/admin/view-research', 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
						}else{
							return Html::a('<span class="glyphicon glyphicon-search"></span> VIEW',['/erpd/admin/view-research', 'id' => $model->id],['class'=>'btn btn-default btn-sm']);
						}
                        
                    }
                ],
            
            ],

        ];


?>
<div class="research-index">

<div class="form-group"><?=ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $exportColumns,
	'filename' => 'RESEARCH_DATA_' . date('Y-m-d'),
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
<div class="box-body">  <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
		'options' => [ 'style' => 'table-layout:fixed;' ],
		
        'columns' => $colums,
    ]); ?></div>
</div>
</div>


