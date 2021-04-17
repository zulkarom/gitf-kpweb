<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use richardfan\widget\JSRegister;


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
				'attribute' => 'gender',
				'label' => 'Gender',
				'value' => function($model){
						if($model->gender == 1){
							return 'Male';
						}else{
							return 'Female';
						}
					
				}
				
			],
			
			[
				'attribute' => 'position_id',
				'value' => function($model){
					if($model->staffPosition){
						return $model->staffPosition->position_name;
					}
					
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
					if($model->staffPosition){
						return $model->staffPosition->position_name;
					}
					
					
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
<?= Html::button('<span class="glyphicon glyphicon-search"></span> Search',['id' => 'btn-search-show', 'class' => 'btn btn-primary']) ?>

<?=ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $exportColumns,
	'exportConfig' => [
        ExportMenu::FORMAT_PDF => false,
		ExportMenu::FORMAT_EXCEL_X => false,
    ],
	'filename' => 'STAFF_DATA_' . date('Y-m-d'),
	'onRenderSheet'=>function($sheet, $grid){
		$sheet->getStyle('A2:'.$sheet->getHighestColumn().$sheet->getHighestRow())
		->getAlignment()->setWrapText(true);
	},

]);?>

 
 </div>


<div style="display:none" id="con-form-searach">
<?=$this->render('_search', ['model' => $searchModel])?>
</div>



    <div class="box">
<div class="box-header"></div>
<div class="box-body"><?= GridView::widget([
        'dataProvider' => $dataProvider,
		'export' => false,
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
					if($model->staffPosition){
						return $model->staffPosition->position_name;
					}
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


<?php JSRegister::begin(); ?>
<script>
$("#btn-search-show").click(function(){
	$('#con-form-searach').slideDown();
});
$("#hide-form").click(function(){
	$('#con-form-searach').slideUp();
});
</script>
<?php JSRegister::end(); ?>