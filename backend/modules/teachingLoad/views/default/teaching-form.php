<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use backend\modules\staff\models\StaffPositionStatus;
use backend\modules\esiap\models\Course;
use richardfan\widget\JSRegister;
use common\models\Country;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;

$this->title = 'Teaching Information Form';
?>

<?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>


<div class="row">
<div class="col-md-6">



<div class="box box-primary">
<div class="box-header">
<div class="box-title">Basic Information</div>
</div>
<div class="box-body">





<div class="row">
<div class="col-md-6">

<?php 

if(in_array($staff->staff_title, $staff->listTitles)){
	echo $form->field($staff , 'staff_title', ['template' => '{label}<div id="con-title">{input}</div>{error}']
)->label('Staff Designation')->dropDownList($staff->listTitles);
}else{
	echo $form->field($staff , 'staff_title')->inputText()->label('Staff Designation');
}



?>

</div>
</div>



<div class="row">
<div class="col-md-10">
<?= $form->field($user, 'fullname')->textInput(['readonly' => true])->label('Staff Name') ?></div>

</div>


<div class="row">
<div class="col-md-7"><?= $form->field($staff, 'position_status')->dropDownList(ArrayHelper::map(StaffPositionStatus::find()->where(['>', 'id', 0])->all(), 'id', 'status_name'), ['prompt' => 'Please Select' ])->label('Current Appointment Status') ?></div>

</div>


<div class="row">
<div class="col-md-7">
<?php 


echo $form->field($staff, 'nationality')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(Country::find()->all(),'country_code', 'country_name'),
    'language' => 'en',
    'options' => ['multiple' => false,'placeholder' => 'Select a country ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
])->label('Nationality');


?>
	</div>

</div>



	
	


  



</div>
</div>



<div class="box box-warning">
<div class="box-header">
<h3 class="box-title">Previously Taught Courses</h3>
</div>
<div class="box-body">


<?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper',
        'widgetBody' => '.container-items',
        'widgetItem' => '.taughtCourse-item',
        'limit' => 10,
        'min' => 1,
        'insertButton' => '.add-taughtCourse',
        'deleteButton' => '.remove-taughtCourse',
        'model' => $taughtCourses[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'course_id',
        ],
    ]); ?>

    
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Courses</th>
                <th class="text-center" width="5%">
                    
                </th>
            </tr>
        </thead>
        <tbody class="container-items">
        <?php foreach ($taughtCourses as $i => $taughtCourse): ?>
            <tr class="taughtCourse-item">
            
                <td class="vcenter">
                    <?php
                        // necessary for update action.
                        if (! $taughtCourse->isNewRecord) {
                            echo Html::activeHiddenInput($taughtCourse, "[{$i}]id");
                        }
                    ?>
					
					
					

                    <?= $form->field($taughtCourse, "[{$i}]course_id")->dropDownList(ArrayHelper::map(Course::find()->where(['faculty_id' => Yii::$app->params['faculty_id'], 'is_dummy' => 0, 'is_active' => 1])->orderBy('course_code ASC')->all(), 'id', 'codeAndCourse'), ['prompt' => 'Please Select' ])->label(false) ?>
                </td>
                

                <td class="text-center vcenter" style="width: 90px; verti">
                    <button type="button" class="remove-taughtCourse btn btn-default btn-sm"><span class="fa fa-remove"></span></button>
                </td>
            </tr>
         <?php endforeach; ?>
        </tbody>
        
        <tfoot>
            <tr>
                <td colspan="2">
                <button type="button" class="add-taughtCourse btn btn-default btn-sm"><span class="fa fa-plus"></span> Add Taught Courses</button>
                
                </td>
        
            </tr>
        </tfoot>
        
    </table>
    <?php DynamicFormWidget::end(); ?>




</div>
</div>



</div>

<div class="col-md-6">

<div class="box box-primary">
<div class="box-header">
<div class="box-title">Highest Academic Qualification</div>
</div>
<div class="box-body">

<div class="row">
<div class="col-md-4">

<?php 
	echo $form->field($staff , 'high_qualification')->label('Qualification')->dropDownList(['PhD'=> 'PhD', 'Sarjana'=> 'Sarjana', 'Sarjana Muda'=> 'Sarjana Muda', ]);

?>

</div>
<div class="col-md-4">
<?php 
if($staff->hq_year == '0000'){
	$staff->hq_year = date('Y');
}

echo $form->field($staff, 'hq_year'
)->textInput()->label('Year') ?></div>
</div>



<div class="row">
<div class="col-md-10">
<?php echo $form->field($staff, 'hq_specialization', ['template' => '{label}{input}<i>e.g. Economics, Business, Accounting, Law</i>{error}
            ']
)->textInput()->label('Specialization') ?>

</div>

</div>

<div class="row">
<div class="col-md-11">
<?php echo $form->field($staff, 'hq_institution')->textInput()->label('Awarding Institution') ?>

</div>

</div>



<div class="row">
<div class="col-md-7">
<?php 


echo $form->field($staff, 'hq_country')->widget(Select2::classname(), [
    'data' => ArrayHelper::map(Country::find()->all(),'country_code', 'country_name'),
    'language' => 'en',
    'options' => ['multiple' => false,'placeholder' => 'Select a country ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
])->label('Country');


?>
	</div>

</div>



	
	


  



</div>
</div>
</div>

</div>




<div class="form-group">
        
<?= Html::submitButton('Save Teaching Information', ['class' => 'btn btn-success']) ?>
    </div>
	
	
  <?php ActiveForm::end(); ?>
  
  
  
<?php JSRegister::begin(); ?>
<script>
$("#staff-staff_title").change(function(){
	var val = $(this).val();
	if(val == 999){
		var html = '<input type="text" id="staff-staff_title" placeholder="Please specify" class="form-control" name="Staff[title]" / >';
		$("#con-title").html(html);
	}
});
</script>
<?php JSRegister::end(); ?>