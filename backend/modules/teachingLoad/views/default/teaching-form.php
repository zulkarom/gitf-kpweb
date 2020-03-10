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
<?=$form->field($staff, 'updated_at')->hiddenInput(['value' => 1])->label(false)?>
<p><b><i>* please complete this form before <?=date('d M Y', strtotime($setting->date_end))?></i></b></p>

<div class="row">
<div class="col-md-12">


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
					
					
					

                    <?= $form->field($taughtCourse, "[{$i}]course_id")->dropDownList(ArrayHelper::map(Course::find()->where(['faculty_id' => Yii::$app->params['faculty_id'], 'is_dummy' => 0, 'is_active' => 1, 'method_type' => 1])->orderBy('course_code ASC')->all(), 'id', 'codeAndCourse'), ['prompt' => 'Please Select' ])->label(false) ?>
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


</div>





<div class="box box-danger">
<div class="box-header">
<h3 class="box-title">FOUR (4) Courses That Able to Teach</h3>
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
					
					
					

                    <?= $form->field($teachCourse, "[{$i}]course_id")->dropDownList(ArrayHelper::map(Course::find()->where(['faculty_id' => Yii::$app->params['faculty_id'], 'is_dummy' => 0, 'is_active' => 1, 'method_type' => 1])->orderBy('course_code ASC')->all(), 'id', 'codeCourseCredit'), ['prompt' => 'Please Select' ])->label(false) ?>
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