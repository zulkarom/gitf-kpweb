<?php 
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use backend\modules\staff\models\Staff;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

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

<?php $form = ActiveForm::begin(); ?>

<div class="row">
<div class="col-md-6"><?php
		echo $form->field($audit, 'staff_id')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(Staff::getAcademicStaff(), 'id', 'user.fullname'),
    'options' => ['placeholder' => 'Select an Auditor ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
])->label(false);

?></div>
<div class="col-md-6"><?= Html::submitButton('Assign', ['class' => 'btn btn-success']) ?></div>
</div>



<div class="box">
    <div class="box-header"></div>
    <div class="box-body"><div class="table-responsive"><?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
			['class' => 'yii\grid\CheckboxColumn'],
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
						return $model->course->program->pro_name_short;
					}
					
				}
                
            ], */
			
			[
                'value' => 'progressOverallBar',
                'label' => 'Progress',
				'format' => 'html'
                
            ],
			
			'statusName:html',
			
			
			[
				'attribute' => 'auditor.user.fullname',
				'label' => 'Auditor',
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
                        return Html::a('<span class="glyphicon glyphicon-search"></span> View', ['admin/course-files-view', 'id' => $model->id], ['class' => 'btn btn-default btn-sm'
                        ]) 
                ;
                    }
                   

                ],
            
            ],
			

        ],
    ]); ?></div>
    </div>
</div>

<?php ActiveForm::end(); ?>