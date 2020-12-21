<?php
use backend\models\Semester;
use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\Url;

$this->title = 'Appointment Letter';
$this->params['breadcrumbs'][] = $this->title;

$form = ActiveForm::begin([
'id' => 'form-semester',
'method' => 'get',
]); ?>  
<div class="row">
	
<div class="col-md-5">
<?= $form->field($semester, 'semester_id')->dropDownList(
        Semester::listSemesterArray()
    )->label(false) ?>
    <input type="hidden" name="btn-action" id="btn-action" value="1" />
</div>
</div>
<?php
ActiveForm::end(); 
?>

<?php
$form = ActiveForm::begin([
'id' => 'form-appointment'
]); ?>  
<div class="form-group">   
<button type="button" id="btn-run" class="btn btn-primary"><span class="fa fa-navicon"></span>  RUN STAFF INVOLVED</button>
<?= Html::a('GENERATE REFERENCE', ['/teaching-load/staff-inv/generate-reference'], ['class' => 'btn btn-warning']) ?>

</div>

<input type="hidden" name="btn-action" id="btn-action" value="2" />

<br />

    <div class="box">
<div class="box-header"></div>
<div class="box-body"><?= GridView::widget([
        'dataProvider' => $dataProvider,
        'export' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            
            [
                'label' => 'Staff Name',
                'value' => function($model){
                    return $model->staff->staff_title . ' ' . $model->staff->user->fullname ;
                }
                
            ],

            [
                'label' => 'Course Name',
                'format' => 'raw',
                'value' => function($model){
                    return $model->getAppointLetterStr("<br />");
                }
            ],


            

           
            

            
        ],
    ]); ?>
    </div>
</div>

<?php
ActiveForm::end(); 
?>

<?php 
$this->registerJs('

$("#semesterform-semester_id").change(function(){
  
	$("#form-semester").submit();
});

$("#btn-run").click(function(){

	if(confirm("Are you sure to run staff involved?")){
		$("#form-appointment").submit();
	}
	
});

');

?>