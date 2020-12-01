<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\esiap\models\CourseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Selection by Staff';
$this->params['breadcrumbs'][] = $this->title;



$columns = [
            ['class' => 'yii\grid\SerialColumn'],
			
			[
				//'contentOptions' => ['style' => 'width: 45%'],
				//'format' => 'html',
				'label' => 'Staff No.',
				'value' => function($model){
					return $model->staff_no ;
				}
				
			],
            
			[
				//'contentOptions' => ['style' => 'width: 45%'],
				//'format' => 'html',
				'label' => 'Staff Name & Designation',
				'value' => function($model){
					return $model->staff_title . ' ' . $model->user->fullname ;
				}
				
			],
			
			[
                'label' => 'Submitted',
				'format' => 'html',
                'value' => function($model){
			
					return $model->teaching_submit == 1 ? '<span class="label label-success">Yes</span>' : '<span class="label label-danger">No</span>';
                    
                }
            ],
           
			
			[
                'label' => 'Courses Taught',
				'format' => 'html',
                'value' => function($model){
					return $model->taughtCoursesStr;
                }
            ],
			
			
			[
                'label' => 'Four Courses Able to Teach',
				'format' => 'html',
                'value' => function($model){
					return $model->teachCoursesStr;
                }
            ],
			//PastExperiencesStr
			

            /* ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 9%'],
                'template' => '{update}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span> Update',['/esiap/course-admin/update/', 'course' => $model->id],['class'=>'btn btn-warning btn-sm']);
                    },

                ],
            
            ], */
        ];
?>
<div class="course-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
	
	<div class="row">
<div class="col-md-6">
		
		<?=ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $columns,
	'filename' => 'STAFF_TEACHING_' . date('Y-m-d'),
	'onRenderSheet'=>function($sheet, $grid){
		$sheet->getStyle('A2:'.$sheet->getHighestColumn().$sheet->getHighestRow())
		->getAlignment()->setWrapText(true);
	},
	'exportConfig' => [
        ExportMenu::FORMAT_PDF => false,
		ExportMenu::FORMAT_EXCEL_X => false,
    ],
]);?>
		
		
		
 </div>

<div class="col-md-6" align="right">

<?php //=$this->render('_search', ['model' => $searchModel])?>
</div>

</div>
<br />

    <div class="box">
<div class="box-header"></div>
<div class="box-body"><?= GridView::widget([
        'dataProvider' => $dataProvider,
		'export' => false,
       // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			
            
			[
				//'contentOptions' => ['style' => 'width: 45%'],
				//'format' => 'html',
				'label' => 'Staff Name & Designation',
				'value' => function($model){
					return $model->staff_title . ' ' . $model->user->fullname ;
				}
				
			],
            [
                'label' => 'Submitted',
				'format' => 'html',
                'value' => function($model){
			
					return $model->teaching_submit == 1 ? '<span class="label label-success">Yes</span>' : '<span class="label label-danger">No</span>';
                    
                }
            ],
			
			
			[
                'label' => 'Courses Taught',
				'format' => 'html',
                'value' => function($model){
					return $model->getTaughtCoursesStr("<br />");
                }
            ],
			
			[
                'label' => 'Four Courses Able to Teach',
				'format' => 'html',
                'value' => function($model){
					return $model->getTeachCoursesStr("<br />");
                }
            ],
			//PastExperiencesStr
			

            /* ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 9%'],
                'template' => '{update}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span> Update',['/esiap/course-admin/update/', 'course' => $model->id],['class'=>'btn btn-warning btn-sm']);
                    },

                ],
            
            ], */
        ],
    ]); ?></div>
</div>

</div>
