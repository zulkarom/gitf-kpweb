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
<div class="col-md-10">
<?= $form->field($user, 'fullname')->textInput(['readonly' => true])->label('Staff Name') ?></div>

</div>


<div class="row">
<div class="col-md-6">

<?php 

if(in_array($staff->staff_title, $staff->listTitles)){
	echo $form->field($staff , 'staff_title', ['template' => '{label}<div id="con-title">{input}</div>{error}']
)->label('Designation')->dropDownList($staff->listTitles);
}else{
	echo $form->field($staff , 'staff_title')->inputText()->label('Staff Designation');
}



?>

</div>
</div>






<div class="row">
<div class="col-md-6"><?= $form->field($staff, 'position_status')->dropDownList(ArrayHelper::map(StaffPositionStatus::find()->where(['>', 'id', 0])->all(), 'id', 'status_name'), ['prompt' => 'Please Select' ])->label('Current Appointment Status') ?></div>


<div class="col-md-6">
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
 

<?= $form->field($staff, 'research_focus')->textarea(['rows' => 3])->label('Research Focus Area') ?>


</div>
</div>



<div class="box box-warning">
<div class="box-header">
<h3 class="box-title">Previously Taught Courses in This Faculty</h3>
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
<?php echo $form->field($staff, 'hq_institution')->textInput()->label('Awarding Institution & Country') ?>

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
])->label(false);


?>
	</div>

</div>



	
	


  



</div>
</div>


<div class="box box-warning">
<div class="box-header">
<h3 class="box-title">Previously Taught Courses in Other Faculty/University</h3>
</div>
<div class="box-body">


<?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper_out',
        'widgetBody' => '.container-items_out',
        'widgetItem' => '.outCourse-item',
        'limit' => 10,
        'min' => 1,
        'insertButton' => '.add-outCourse',
        'deleteButton' => '.remove-outCourse',
        'model' => $outCourses[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'course_name',
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
        <tbody class="container-items_out">
        <?php foreach ($outCourses as $x => $outCourse): ?>
            <tr class="outCourse-item">
            
                <td class="vcenter">
                    <?php
                        // necessary for update action.
                        if (! $outCourse->isNewRecord) {
                            echo Html::activeHiddenInput($outCourse, "[{$x}]id");
                        }
                    ?>
					
					
					

                    <?= $form->field($outCourse, "[{$x}]course_name")->textInput()->label(false) ?>
                </td>
                

                <td class="text-center vcenter" style="width: 90px; verti">
                    <button type="button" class="remove-outCourse btn btn-default btn-sm"><span class="fa fa-remove"></span></button>
                </td>
            </tr>
         <?php endforeach; ?>
        </tbody>
        
        <tfoot>
            <tr>
                <td colspan="2">
                <button type="button" class="add-outCourse btn btn-default btn-sm"><span class="fa fa-plus"></span> Add Other Taught Courses</button>
                
                </td>
        
            </tr>
        </tfoot>
        
    </table>
    <?php DynamicFormWidget::end(); ?>




</div>
</div>






</div>

</div>


<div class="box box-info">
<div class="box-header">
<h3 class="box-title">Past Work Experiences</h3>
</div>
<div class="box-body">


<?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper_past',
        'widgetBody' => '.container-items_past',
        'widgetItem' => '.pastExpe-item',
        'limit' => 10,
        'min' => 1,
        'insertButton' => '.add-pastExpe',
        'deleteButton' => '.remove-pastExpe',
        'model' => $pastExpes[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'id',
        ],
    ]); ?>



	<table class="table table-bordered table-striped">
 <thead>
            <tr>
                <th width="50%">Employer</th>
				<th>Position</th>
				<th>Years of Service<br />
				<i style="font-weight:normal">(Start and End)</i>
				</th>
                <th class="text-center" width="5%">
                    
                </th>
            </tr>
        </thead>
        <tbody class="container-items_past">
        <?php foreach ($pastExpes as $x => $pastExpe): ?>
            <tr class="pastExpe-item">
            
                <td class="vcenter">
                    <?php
                        // necessary for update action.
                        if (! $pastExpe->isNewRecord) {
                            echo Html::activeHiddenInput($pastExpe, "[{$x}]id");
                        }
                    ?>
					
					
					

                    <?= $form->field($pastExpe, "[{$x}]employer")->textInput()->label(false) ?>
	  
                </td>
				
				
				 <td class="vcenter">
                   <?= $form->field($pastExpe, "[{$x}]position")->textInput()->label(false) ?>

					 
					  
                </td>
				
				<td class="vcenter">
                   <?= $form->field($pastExpe, "[{$x}]start_end")->textInput()->label(false) ?>

					 
					  
                </td>
                

                <td class="text-center vcenter" width="5%">
                    <button type="button" class="remove-pastExpe btn btn-default btn-sm"><span class="fa fa-remove"></span></button>
                </td>
            </tr>
         <?php endforeach; ?>
        </tbody>
        
        <tfoot>
            <tr>
                <td colspan="2">
                <button type="button" class="add-pastExpe btn btn-default btn-sm"><span class="fa fa-plus"></span> Add Experience</button>
                
                </td>
        
            </tr>
        </tfoot>
        
    </table>
    <?php DynamicFormWidget::end(); ?>




</div>
</div>


<div class="box box-danger">
<div class="box-header">
<h3 class="box-title">FOUR (4) Courses Willingly to Teach</h3>
</div>
<div class="box-body">


<?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper_teach',
        'widgetBody' => '.container-items_teach',
        'widgetItem' => '.teachCourse-item',
        'limit' => 10,
        'min' => 4,
        'insertButton' => '.add-teachCourse',
        'deleteButton' => '.remove-teachCourse',
        'model' => $teachCourses[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'course_id',
        ],
    ]); ?>

    
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
			
			<th class="text-center" width="5%">
                   # 
                </th>
                <th>Courses</th>
                
            </tr>
        </thead>
        <tbody class="container-items_teach">
        <?php foreach ($teachCourses as $i => $teachCourse): ?>
            <tr class="teachCourse-item">
            <td class="text-center vcenter">
                  <?=$i + 1 ?> . 
                </td>
                <td class="vcenter">
                    <?php
                        // necessary for update action.
                        if (! $teachCourse->isNewRecord) {
                            echo Html::activeHiddenInput($teachCourse, "[{$i}]id");
                        }
                    ?>
					
					
					

                    <?= $form->field($teachCourse, "[{$i}]course_id")->dropDownList(ArrayHelper::map(Course::find()->where(['faculty_id' => Yii::$app->params['faculty_id'], 'is_dummy' => 0, 'is_active' => 1])->orderBy('course_code ASC')->all(), 'id', 'codeCourseCredit'), ['prompt' => 'Please Select' ])->label(false) ?>
                </td>
                

                
            </tr>
         <?php endforeach; ?>
        </tbody>
        

        
    </table>
    <?php DynamicFormWidget::end(); ?>




</div>
</div>


<div class="form-group">
        
<?= Html::submitButton('SUBMIT FORM', ['class' => 'btn btn-success']) ?>
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