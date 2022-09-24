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
$semester->action = ['/course-files/admin/index'];
?>

<div class="course-files-default-index">
    
</div>

<div class="box box-solid">
<div class="box-header"><h3 class="box-title">FILTER COURSE FILES</h3>
</div>
<div class="box-body">
<?= $this->render('_form_search', [
                'model' => $semester,
            ]) ?>
</div></div>


<?php $form = ActiveForm::begin(['id' =>'form-auditor']); ?>

<div class="box box-solid">
<div class="box-header"><h3 class="box-title">APPOINT AUDITORS</h3>
</div>
<div class="box-body">
<div class="row">
<div class="col-md-6"><?php
$list = ArrayHelper::map(Staff::getAcademicStaff(), 'id', 'user.fullname');
$list["0"] = 'NONE';
		echo $form->field($audit, 'staff_id')->widget(Select2::classname(), [
    'data' => $list,
    'options' => ['placeholder' => 'Select an Auditor ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
])->label(false);

?></div>
<div class="col-md-6">
<input type="hidden" value="" id="form-action" name="form-action" />

<div class="dropdown">
<button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
With selection:
<span class="caret"></span>
</button>
<ul class="dropdown-menu" aria-labelledby="about-us">
<li><a href="#" class="li-action" data-value="1">Assign Internal Auditor</a></li>
<li><a href="#" class="li-action" data-value="2">Assign External Auditor</a></li>
</ul>
</div>


</div>
</div>
</div></div>
        






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
			
			[
                'value' => 'progressOverallBar',
                'label' => 'Progress',
				'format' => 'html'
                
            ],
			
			'statusName:html',
			
			
			[
			    'value' => function($model){
			         return $model->auditorStr;
			    },
			    'format' => 'html',
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



<?php 

$this->registerJs(' 


$(".li-action").click(function(){
var action = $(this).data("value");
$("#form-action").val(action);
$("#form-auditor").submit();

});





');



?>