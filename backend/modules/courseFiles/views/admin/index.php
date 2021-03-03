<?php 
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\teachingLoad\models\CourseOfferedSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Course Files';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="course-files-default-index">
    
</div>

<div class="row">

    <div class="col-md-10" align="right">
        <?= $this->render('_form_course_files', [
                'model' => $semester,
            ]) ?>
    </div>
</div>

<div class="box">
    <div class="box-header"></div>
    <div class="box-body"><?= GridView::widget([
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
			
			/* [
                'label' => 'Program',
				'value' => function($model){
					if($model->course->program){
						return $model->course->program->pro_name_short;
					}
					
				}
                
            ], */
			
			'statusName:html',
            ['class' => 'yii\grid\ActionColumn',
                'contentOptions' => ['style' => 'width: 10.7%'],
                'template' => '{files}',
                'buttons'=>[
                    'files'=>function ($url, $model){
                        return Html::a('<span class="glyphicon glyphicon-search"></span> View', ['admin/course-files-view', 'id' => $model->id], ['class' => 'btn btn-default btn-sm'
                        ]) 
                ;
                    }
                   

                ],
            
            ],

        ],
    ]); ?>
    </div>
</div>





    
