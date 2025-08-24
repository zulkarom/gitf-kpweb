<?php 
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use backend\modules\courseFiles\models\Common;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\teachingLoad\models\CourseOfferedSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

if($dates){
    $closed = Common::isDue($dates->audit_deadline);
    $msg = Common::deadlineMessage($dates->audit_deadline);
}else{
    $closed = false;
    $msg = '';
}


$this->title = 'Internal / External Auditors / Examiners';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="course-files-default-index">
    
</div>

<div class="row">

    <div class="col-md-10" align="right">
        <?php 
        $semester->action = Url::to(['/course-files/auditor/index']);
        echo $this->render('../admin/_form_course_files', [
                'model' => $semester,
            ]) ?>
    </div>
</div>

<div class="form-group"><i style="color:red"><?=$msg?></i></div>


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
			
			
			
			/* [
                'label' => 'Program',
				'value' => function($model){
					if($model->course->program){
						return $model->course->program->program_code;
					}
					
				}
                
            ], */
			
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
                    'files'=>function ($url, $model) use ($closed){
						if($closed){
							return 'closed';
						}else{
							return Html::a('<span class="glyphicon glyphicon-search"></span> View', ['auditor/course-files-view', 'id' => $model->id], ['class' => 'btn btn-default btn-sm'
                        ]) 
                ;
						}
                        
                    }
                   

                ],
            
            ],
			

        ],
    ]); ?></div>
    </div>
</div>