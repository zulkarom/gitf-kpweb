<?php

use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\esiap\models\CourseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Course Verification';
$this->params['breadcrumbs'][] = $this->title;



$exportColumns = [
	
	['class' => 'yii\grid\SerialColumn'],
			'course_code',
            'course_name',
			'course_name_bi',
			'credit_hour',
			[
				'attribute' => 'program.pro_name_short',
				'label' => 'Program',
			],
			
            [
                'label' => 'Publish',
                'format' => 'html',
                'value' => function($model){
					if($model->publishedVersion){
						$lbl = 'YES';
						$color = 'success';
					}else{
						$lbl =  'NO';
						$color = 'danger';
					}
					
					return '<span class="label label-'.$color.'">'.$lbl.'</span>';
                    
                }
            ],
			[
                'label' => 'Development',
                'format' => 'html',
                
                'value' => function($model){
					if($model->developmentVersion){
						return $model->developmentVersion->labelStatus;
					}else{
						return 'NONE';
					}
                    
                }
            ],
			
			[
				'label' => 'Person In Charge',
				'format' => 'html',
				'value' => function($model){
					return $model->picStr;
				}
				
			],
			
			[
				'label' => 'Staff View',
				'format' => 'html',
				'value' => function($model){
					return $model->staffViewStr;
				}
				
			]

];
?>
<div class="course-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
	
	<div class="row">
<div class="col-md-5">
       <div class="form-group">  
		
		<?=ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $exportColumns,
	'filename' => 'COURSE_DATA_' . date('Y-m-d'),
	'onRenderSheet'=>function($sheet, $grid){
		$sheet->getStyle('A2:'.$sheet->getHighestColumn().$sheet->getHighestRow())
		->getAlignment()->setWrapText(true);
	},
	'exportConfig' => [
        ExportMenu::FORMAT_PDF => false,
		ExportMenu::FORMAT_EXCEL_X => false,
    ],
]);?></div>
		
		
		
 </div>

<div class="col-md-7" align="right">

<?=$this->render('_search', ['model' => $searchModel])?>
</div>

</div>

<?php $form = ActiveForm::begin([
	'action' => Url::to(['/esiap/course-admin/table4'])
]); ?>

    <div class="box box-primary">
<div class="box-header"></div>
<div class="box-body">



<?php

if(Yii::$app->params['faculty_id'] == 21 ){
	$cat = [
				'label' => 'Component',
				'value' => function($model){
					return $model->component->name;
				}
				
			];
}else{
	$cat = [
				'label' => 'Program',
				'value' => function($model){
					if($model->program){
						return $model->program->pro_name_short;
					}
					
				}
				
			];
}

echo GridView::widget([
         'dataProvider' => $dataProvider,
		'options' => [ 'style' => 'table-layout:fixed;' ],
		'export' => false,
       // 'filterModel' => $searchModel,
        'columns' => [
			['class' => 'yii\grid\CheckboxColumn'],
            ['class' => 'yii\grid\SerialColumn'],
		
            
			[
				'attribute' => 'course_name',
			//	'contentOptions' => ['style' => 'width: 45%'],
				'format' => 'html',
				'label' => 'Course Code & Name',
				'value' => function($model){
					
					return $model->course_code . ' ' . strtoupper($model->course_name) . '<br /><i>' . strtoupper($model->course_name_bi) . '</i>';
					
					
				}
				
			],
			
			[
				'label' => 'Credit',
				'value' => function($model){
					return $model->credit_hour;
				}
				
			],
			
			$cat ,
			

			
			
			
           
			[
                'label' => 'Development',
                'format' => 'html',
                
                'value' => function($model){
					if($model->developmentVersion){
						
						return $model->developmentVersion->labelStatus;
					}else{
						return 'NONE';
					}
                    
                }
            ],
			
			
			[
                'label' => 'Report',
                'format' => 'raw',
                'value' => function($model){
					return $model->reportList('View');
                    
                }
            ],
			


            
        ],
    ]); ?></div>
</div>



<div class="form-group">
        
<?= Html::submitButton('<span class="fa fa-check"></span> Approve Selected', ['class' => 'btn btn-success', 'name'=> 'actiontype', 'value' => 'generate']) ?> 

<?= Html::submitButton('<span class="fa fa-remove"></span> Disapprove Selected', ['class' => 'btn btn-warning', 'name'=> 'actiontype', 'value' => 'generate']) ?>
    </div>

<?php ActiveForm::end(); ?>


<?php 

$js = '
$("#checkAll").click(function(){
    $(\'input:checkbox\').not(this).prop(\'checked\', this.checked);
});

';
$this->registerJs($js);
?>


</div>
