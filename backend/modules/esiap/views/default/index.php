<?php 
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'Course Management';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="box">
<div class="box-header">
<h3 class="box-title">Course Owner</h3>
</div>
<div class="box-body"><div class="table-responsive"><?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			
			[
                'label' => 'Course Code & Name',
                'format' => 'html',
                
                'value' => function($model){
					$course = $model->course;
					if($course){
						$version = $course->developmentVersion;
					
					
						if($version){
							return Html::a( $course->course_code . ' ' . strtoupper($course->course_name) . ' / <i>' . strtoupper($course->course_name_bi) . '</i> <span class="glyphicon glyphicon-pencil"></span>',['/esiap/course/view-course/', 'course' => $course->id]);
						}else{
							return $course->course_code . ' ' . strtoupper($course->course_name) . '<br /><i>' . strtoupper($course->course_name_bi) . '</i>';
						}
						
					}
					
					
					
                    
                }
            ],
			
			[
				'label' => 'Credit',
				'value' => function($model){
					if($model->course){
						return $model->course->credit_hour;
					}
					
				}
				
			],
			
			[
				'label' => 'Version',
				'value' => function($model){
					if($model->course){
						if($model->course->developmentVersion){
						return $model->course->developmentVersion->version_name;
					}else{
						return 'NONE';
					}
					}
					
					
				}
				
			],
			
			[
                'label' => 'Status',
                'format' => 'html',
                
                'value' => function($model){
					if($model->course){
						if($model->course->developmentVersion){
						
						return $model->course->developmentVersion->labelStatus;
					}else{
						return 'NONE';
					}
					}
					
                    
                }
            ],
			
			[
                'label' => 'Documents',
                'format' => 'raw',
                'value' => function($model){
					if($model->course){
						if($model->course->developmentVersion){
						return $model->course->reportList('View Documents', $model->course->developmentVersion->id);
					}else{
						return 'NONE';
					}
					}
					
					
                    
                }
            ],
			
			[
				'label' => '',
			//	'contentOptions' => ['style' => 'width: 45%'],
				'format' => 'html',
				'value' => function($model){
				$str = '<a href="'. Url::to(['/esiap/course/resources', 'id' => $model->course_id]) .'" class="btn btn-primary btn-sm"><i class="fa fa-book"></i> Resources</a> ';
					if($model->course){
						$course = $model->course;
					
					$version = $course->developmentVersion;
					
					
						if($version){
							$str .= Html::a( '<span class="fa fa-pencil"></span> Update',['/esiap/course/view-course/', 'course' => $course->id], ['class' => 'btn btn-warning btn-sm']);
						}
					}
					
					return $str;
					
				}
				
			],

           
        ],
    ]); ?></div></div>
</div>

<div class="box">
<div class="box-header">
<h3 class="box-title">Course View</h3>
</div>
<div class="box-body">

<div class="table-responsive"><?= GridView::widget([
        'dataProvider' => $dataProvider2,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			'course.course_code',
            'course.course_name',
			'course.course_name_bi',
			'course.credit_hour',
			
			[
				'label' => 'Course Owner',
				'format' => 'html',
				'value' => function($model){
					if($model->course){
						return $model->course->picStr;
					}
					
				}
				
			],

			[
                'label' => 'Documents',
                'format' => 'raw',
                'value' => function($model){
					if($model->course){
						return $model->course->reportList('View Documents');
					}
					
                    
                }
            ],
			[
                'label' => 'Resources',
                'format' => 'raw',
                'value' => function($model){
					return '<a href="'. Url::to(['/esiap/course/resources', 'id' => $model->course_id]) .'" class="btn btn-primary btn-sm"><i class="fa fa-book"></i> Resources</a>';
					
                    
                }
            ]
        ],
    ]); ?></div></div>
</div>




<?php 
/* 
if($dataProvider4->getCount() > 0){?>
<div class="box box-primary">
<div class="box-header">
<h3 class="box-title">My Program(s)</h3>
</div>
<div class="box-body">

<div class="table-responsive"><?= GridView::widget([
        'dataProvider' => $dataProvider4,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			'program.pro_name',


            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 25%'],
                'template' => '',
                //'visible' => false,
                'buttons'=>[
                ],
            
            ],
        ],
    ]); ?></div></div>
</div>
<?php 
}

if($dataProvider3->getCount() > 0){?>
<div class="box box-danger">
<div class="box-header">
<h3 class="box-title">Under Development Program(s)</h3>
</div>
<div class="box-body"><div class="table-responsive"><?= GridView::widget([
        'dataProvider' => $dataProvider3,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
			'program.pro_name',
			[
				'attribute' => 'program.developmentVersion.labelStatus',
				'label' => 'Status',
				'format' => 'html'
			],

            ['class' => 'yii\grid\ActionColumn',
                 'contentOptions' => ['style' => 'width: 10%'],
                'template' => '{update}',
                //'visible' => false,
                'buttons'=>[
                    'update'=>function ($url, $model) {
						$version = $model->program->developmentVersion;
						if($version){
							return Html::a('<span class="glyphicon glyphicon-pencil"></span> Update',['/esiap/program/update/', 'program' => $model->program_id],['class'=>'btn btn-warning btn-sm']);
						}else{
							return 'NO UDV';
						}
                        
                    },
                ],
            
            ],
        ],
    ]); ?></div></div>
</div>

<?php }  */?>