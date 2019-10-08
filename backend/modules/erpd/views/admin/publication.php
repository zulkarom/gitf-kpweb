<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use backend\modules\erpd\models\PubType;
use kartik\grid\GridView;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\erpd\models\PublicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'All Publications';
$this->params['breadcrumbs'][] = $this->title;

$exportColumns = [

['class' => 'yii\grid\SerialColumn'],
			[
				'attribute' => 'pub_year',
				'contentOptions' => [ 'style' => 'width: 10%;' ],
				
			],
            [
				'attribute' => 'pub_type',
				
				'value' => function($model){
					return $model->pubType->type_name;
				},
				'label' => 'Type'
			],
			'pub_title',
			[
				'label' => 'Authors',
				'value' => function($model){
					return $model->stringAuthorsPlain("\n");
				}
			],
			
			'pub_journal',
			'pub_volume',
			'pub_issue',
			'pub_page',
			'pub_index',
			'pub_isbn',
			'pub_inbook',
			'pub_city',
			'pub_state',
			'pub_publisher',
			[
				'label' => 'Editors',
				'value' => function($model){
					return $model->stringEditorsPlain("\n");
				}
			],
			'pub_organizer',
			'pub_month',
			'pub_day',
			'pub_date',
			[
				'label' => 'Tag Staff',
				'value' => function($model){
					return $model->getTagStaffNames("\n");
				}
			],
			[
                'label' => 'Summary',
                'format' => 'html',
				'value' => function($model){
					return $model->showApaStyle();
				},
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

            ,

            

];
?>
<div class="publication-index">

<div class="form-group"><?=ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $exportColumns,
	'filename' => 'PUBLICATION_DATA_' . date('Y-m-d'),
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
<div class="box-body">   <?= GridView::widget([
        'dataProvider' => $dataProvider,
		'options' => [ 'style' => 'table-layout:fixed;' ],
		'export' => false,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			[
				'label' => '',
				'format' => 'raw',
				'contentOptions' => [ 'style' => 'width: 1%;' ],
				'value' => function($model){
					
					return '<a href="'.Url::to(['/erpd/publication/download-file', 'attr' => 'pubupload', 'id' => $model->id]).'" target="_blank"><i class="fa fa-file-pdf-o"></i></a>';
				}
				
			],
			[
				'attribute' => 'pub_year',
				'contentOptions' => [ 'style' => 'width: 10%;' ],
				'filter' => Html::activeDropDownList($searchModel, 'pub_year', $searchModel->myUniqueYear(),['class'=> 'form-control','prompt' => 'All']),
			],
            [
				'attribute' => 'pub_type',
				'filter' => Html::activeDropDownList($searchModel, 'pub_type', ArrayHelper::map(PubType::find()->all(), 'id','type_name'),['class'=> 'form-control','prompt' => 'Choose Type']),
				'value' => function($model){
					return $model->pubType->type_name;
				},
				'label' => 'Type'
			],
            
			[
                'attribute' => 'pub_title',
                'format' => 'html',
				'value' => function($model){
					return $model->showApaStyle();
				},
                'contentOptions' => [ 'style' => 'width: 60%;' ],
            ],
			
			[
				'attribute' => 'status',
                'format' => 'html',
				'filter' => Html::activeDropDownList($searchModel, 'status', [10 => 'SUBMIT', 20 => 'VERIFIED'],['class'=> 'form-control','prompt' => 'Choose Status']),
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
							return Html::a('<span class="glyphicon glyphicon-eye-open"></span> VERIFY',['/erpd/admin/view-publication', 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
						}else{
							return Html::a('<span class="glyphicon glyphicon-search"></span> VIEW',['/erpd/admin/view-publication', 'id' => $model->id],['class'=>'btn btn-default btn-sm']);
						}
                       
                    }
                ],
            
            ],

        ],
    ]); ?></div>
</div>

</div>
