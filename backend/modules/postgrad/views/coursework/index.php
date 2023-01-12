<?php 
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\date\DatePicker;
use yii\widgets\ActiveForm;
use backend\modules\courseFiles\models\Common;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\teachingLoad\models\CourseOfferedSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Coursework';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">

    <div class="col-md-10" align="right">
        <?= $this->render('_form_semester', [
                'model' => $semester,
            ]) ?>
    </div>
</div>
<div class="course-files-default-index">


<div class="box">
<div class="box-header"></div>
<div class="box-body">  

<div class="table-responsive"><?= GridView::widget([
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
				if($model->course){
				    if($model->course->program){
				        return $model->course->program->program_code;
				    }
				}
					
					
				}
                
            ],
            ['class' => 'yii\grid\ActionColumn',
                //'contentOptions' => ['style' => 'width: 10.7%'],
                'template' => '{files}',
                'buttons'=>[
                    'files'=>function ($url, $model){
                        return Html::a('<span class="fa fa-download"></span> Download Result', ['download', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm', 'target' => '_blank'
                        ]) 
                ;
                    }
                   

                ],
            
            ],
			

        ],
    ]); ?></div>


</div>
</div>
</div>

    
