<?php 
use yii\helpers\Html;
use yii\grid\GridView;
use backend\modules\courseFiles\models\Common;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\teachingLoad\models\CourseOfferedSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Head of Department';
$this->params['breadcrumbs'][] = $this->title;
$semester->action = ['/course-files/program/head-department'];
$department_name = '';
if($department){
    $department_name = $department->dep_name;
}
?>

<div class="course-files-default-index">
    
</div>

<div class="row">

    <div class="col-md-10" align="right">
        <?= $this->render('../admin/_form_course_files', [
                'model' => $semester,
            ]) ?>
    </div>
</div>

<h4><?php echo $department_name?></h4>
<div class="box">
    <div class="box-header"></div>
    <div class="box-body"><div class="table-responsive"><?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'course.course_code',
                'label' => 'Course Code',
            ],
            [
                'attribute' => 'course.course_name',
                'label' => 'Course Name',
            ],
			
			[
				'attribute' => 'coor.user.fullname',
				'label' => 'Coordinator',
			],
			
			
			
			[
                'label' => 'Program',
				'value' => function($model){
					if($model->course->program){
						return $model->course->program->pro_name_short;
					}
					
				}
                
            ], 
			
			'statusName:html',
			
			[
                'value' => 'progressOverallBar',
                'label' => 'Progress',
				'format' => 'html'
                
            ],
			
			[
				//'attribute' => 'is_audited',
				'label' => 'Audited',
				'format' => 'html',
				'value' => function($model){
					if($model->is_audited == 1){
						return '<span class="label label-success">YES</span>';
					}else{
						return '<span class="label label-danger">NO</span>';
					}
				}
				
			],
			
			
            ['class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['style' => 'width: 10.7%'],
                'template' => '{files}',
                'buttons'=>[
                    'files'=>function ($url, $model){
							return Html::a('<span class="glyphicon glyphicon-search"></span> View', ['program/course-files-coor-view', 'id' => $model->id], ['class' => 'btn btn-default btn-sm'
                        ]) 
                ;
                        
                    }
                   

                ],
            
            ],
			

        ],
    ]); ?></div>
    </div>
</div>