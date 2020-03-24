<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\ArrayHelper;
use backend\modules\esiap\models\Course;

$directoryAsset = Yii::$app->assetManager->getPublishedUrl('@frontend/views/myasset');

/**
 * @var yii\web\View $this
 * @var dektrium\user\models\LoginForm $model
 * @var dektrium\user\Module $module
 */

$this->title = 'TAUGHT COURSES BY ACADEMIC STAFF';
$this->params['breadcrumbs'][] = $this->title;

?>
<?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>						

			<?=$form->field($model, 'updated_at')->hiddenInput(['value' => 1])->label(false)?>
			
<div class="row">

<div class="col-md-12">

Due Date: <?=date('d M Y' , strtotime($setting->date_end))?>
<br />
Time Remaining: <span style="color:red">
<?php 
if(strtotime($setting->date_end) < time()){
	echo '---';
}else{
	$now = new \DateTime();
$future_date = new \DateTime($setting->date_end . ' 11:59:59');
//$future_date->modify('+ 8 hours');
$interval = $future_date->diff($now);

echo $interval->format("%a days, %h hours");
}

?>
</span>

<br /><br />

<div class="box box-primary">
<div class="box-header">
<div class="box-title">Staff Information</div>
</div>
<div class="box-body">


<div class="table-responsive">
  <table class="table table-striped table-hover">
    <tbody>
	 <tr>
	 <td width="20%"><b>Staff No.</b></td>
        <td><?=$model->staff_no?></td>
        
      </tr>
      <tr>
        <td><b>Staff Name</b></td>
        <td><?=$model->staff_title . ' ' . $model->user->fullname?></td>
      </tr>
    </tbody>
  </table>
</div>


<div class="row">
<div class="col-md-6">



</div>
</div>



 



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
        
<?= Html::submitButton('SUBMIT', ['class' => 'btn btn-success']) ?>
    </div>


</div>

</div>
				
 

<?php ActiveForm::end(); ?>

