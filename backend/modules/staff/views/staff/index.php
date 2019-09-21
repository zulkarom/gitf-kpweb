<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;


/* @var $this yii\web\View */
/* @var $searchModel backend\modules\staff\models\StaffSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Staff';
$this->params['breadcrumbs'][] = $this->title;

$exportColumns = [
 ['class' => 'yii\grid\SerialColumn'],
            'staff_no',
			'staff_title',
			[
				'attribute' => 'staff_name',
				'label' => 'Staff Name',
				'value' => function($model){
					if($model->user){
						return $model->user->fullname;
					}
					
				}
				
			],
			[
				'attribute' => 'position_id',
				'value' => function($model){
					return $model->staffPosition->position_name;
				}
				
			],
			[
				'label' => 'Email',
				'value' => function($model){
					if($model->user){
						return $model->user->email;
					}
					
				}
				
			],
			[
				'attribute' => 'is_academic',
				'value' => function($model){
					if($model->is_academic == 1){
						return 'Academic';
					}else{
						return 'Administrative';
					}
					
				}
				
			],
			
			[
				'attribute' => 'position_status',
				'value' => function($model){
					return $model->staffPosition->position_name;
					
				}
				
			],
			
			[
				'attribute' => 'working_status',
				'value' => function($model){
					return $model->workingStatus->work_name;
					
				}
				
			],
			'staff_edu',
			'staff_gscholar',
			'staff_expertise',
			'staff_interest',
			'officephone',
			'handphone1',
			'handphone2',
			'staff_ic',
			'staff_dob',
			'date_begin_umk',
			'date_begin_service',
			'personal_email',
			'ofis_location'

];
?>
<div class="staff-index">


<div class="form-group">
<?= Html::a('<span class="glyphicon glyphicon-plus"></span> Add New Staff', ['create'], ['class' => 'btn btn-success']) ?>

 
 </div>



<?=$this->render('_search', ['model' => $searchModel])?>


<div class="form-group">

<b>EXPORT DATA</b>  <?=ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $exportColumns,
	'filename' => 'STAFF_DATA_' . date('Y-m-d'),
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
]);?> </div>

    <div class="box">
<div class="box-header"></div>
<div class="box-body"><?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'staff_no',
			[
				'attribute' => 'staff_name',
				'label' => 'Staff Name',
				'value' => function($model){
					if($model->user){
						return $model->staff_title . ' ' . $model->user->fullname;
					}
					
				}
				
			],
			[
				'attribute' => 'position_id',
				'value' => function($model){
					return $model->staffPosition->position_name;
				}
				
			],
            
            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 8.7%'],
                'template' => '{update}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span> UPDATE',['/staff/staff/update/', 'id' => $model->id],['class'=>'btn btn-warning btn-sm']);
                    }
                ],
            
            ],

        ],
    ]); ?></div>
</div>
</div>
