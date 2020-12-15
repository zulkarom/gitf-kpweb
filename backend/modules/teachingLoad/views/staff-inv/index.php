<?php
use backend\models\Semester;
use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use kartik\grid\GridView;

$this->title = 'Appointment Letter';
$this->params['breadcrumbs'][] = $this->title;

$form = ActiveForm::begin([
'id' => 'form-appointment'
]); ?>  
<div class="row">
	
<div class="col-md-5">
<?= $form->field($semester, 'semester_id')->dropDownList(
        Semester::listSemesterArray()
    )->label(false) ?>
</div>
</div>

<div class="form-group">   
<button type="button" class="btn btn-warning" id="btn-run"><span class="fa fa-gears"></span>  RUN STAFF INVOLVED</button>
<button type="button" id="btn-create" class="btn btn-primary"><span class="fa fa-navicon"></span> CREATE APPOINTMENT LETTER</button>

</div>

<input type="hidden" name="btn-action" id="btn-action" value="" />

<br />

    <div class="box">
<div class="box-header"></div>
<div class="box-body"><?= GridView::widget([
        'dataProvider' => $dataProvider,
        'export' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            
            [
                'label' => 'Staff',
                'value' => function($model){
                    return $model->staff->staff_title . ' ' . $model->staff->user->fullname ;
                }
                
            ],

            [
                'label' => 'Appointment',
                'value' => function($model){
                    return "" ;
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
	$("#sel-sem-form").submit();
});

$("#btn-run").click(function(){
	$("#btn-action").val(0);
	if(confirm("Are you sure to run staff involved?")){
		$("#form-appointment").submit();
	}
	
});

$("#btn-create").click(function(){
	$("#btn-action").val(0);
	if(confirm("Are you sure to run this autoload?")){
		$("#form-appointment").submit();
	}
	
});

');

?>