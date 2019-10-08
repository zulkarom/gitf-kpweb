<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use kartik\export\ExportMenu;


/* @var $this yii\web\View */
/* @var $searchModel backend\modules\erpd\models\PublicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Lecturers';
$this->params['breadcrumbs'][] = $this->title;

$columns = [

 ['class' => 'yii\grid\SerialColumn'],
			[
				'attribute' => 'user.fullname',
				'label' => 'Name',
				
			],
			
			
			[
				'label' => 'Research',
				'value' => function($model){
					return $model->totalResearch;
				}
				
			],
			[
				'label' => 'Publication',
				'value' => function($model){
					return $model->totalPublication;
				}
				
			],
			
			[
				'label' => 'Membership',
				'value' => function($model){
					return $model->totalMembership;
				}
				
			],
			
			[
				'label' => 'Award',
				'value' => function($model){
					return $model->totalAward;
				}
				
			],
			
			[
				'label' => 'Consultation',
				'value' => function($model){
					return $model->totalConsultation;
				}
				
			],
			
			[
				'label' => 'Knowledge Transfer',
				'value' => function($model){
					return $model->totalKtp;
				}
				
			],

            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 8.7%'],
                'template' => '{update}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
						
						return Html::a('<span class="glyphicon glyphicon-search"></span> VIEW',['/erpd/admin/lecturer-overall', 'id' => $model->id],['class'=>'btn btn-primary btn-sm']);
                       
                    }
                ],
            
            ],
];
?>
<div class="publication-index">

<div class="form-group"><?=ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $columns,
	'filename' => 'LECTURER_DATA_' . date('Y-m-d'),
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
<div class="box-body">   

<?= GridView::widget([
        'dataProvider' => $dataProvider,
		'options' => [ 'style' => 'table-layout:fixed;' ],
        //'filterModel' => $searchModel,
        'columns' => $columns,
    ]); ?></div>
</div>

</div>
