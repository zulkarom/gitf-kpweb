<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\esiap\models\CourseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Teaching Information by Staff';
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
                'label' => 'Appointment Status',
                'value' => function($model){
			
					return $model->staffPositionStatus->status_cat;
                    
                }
            ],
			
			[
                'label' => 'Nationality',
                'value' => function($model){
			
					return $model->staffNationality->country_name;
                    
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
                'label' => 'Courses Taught (Others)',
				'format' => 'html',
                'value' => function($model){
					return $model->otherTaughtCoursesStr;
                }
            ],
			
			[
                'label' => 'Academic Qualification',
				'format' => 'html',
                'value' => function($model){
					return $model->highAcademicQualification;
                }
            ],
			
		
			[
                'label' => 'Research Focus',
                'value' => function($model){
					return $model->research_focus;
                }
            ],
			
			[
                'label' => 'Past Work Experiences',
				'format' => 'html',
                'value' => function($model){
					return $model->pastExperiencesStr;
                }
            ],
			
			[
                'label' => 'Four Courses Willingly to Teach',
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
                'label' => 'Appointment Status',
                'value' => function($model){
			
					return $model->staffPositionStatus->status_cat;
                    
                }
            ],
			
			[
                'label' => 'Nationality',
                'value' => function($model){
			
					return $model->staffNationality->country_name;
                    
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
                'label' => 'Courses Taught (Others)',
				'format' => 'html',
                'value' => function($model){
					return $model->getOtherTaughtCoursesStr("<br />");
                }
            ],
			
			[
                'label' => 'Academic Qualification',
				'format' => 'html',
                'value' => function($model){
					return $model->getHighAcademicQualification("<br />");
                }
            ],
			
		
			[
                'label' => 'Research Focus',
                'value' => function($model){
					return $model->research_focus;
                }
            ],
			
			[
                'label' => 'Past Work Experiences',
				'format' => 'html',
                'value' => function($model){
					return $model->getPastExperiencesStr("<br />");
                }
            ],
			
			[
                'label' => 'Four Courses Willingly to Teach',
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
