<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use wbraganca\dynamicform\DynamicFormWidget;
use backend\modules\staff\models\Staff;

/* @var $this yii\web\View */
/* @var $model backend\modules\esiap\models\Course */

$this->title = 'Update: ' . $model->course_name;
$this->params['breadcrumbs'][] = ['label' => 'Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Update';
?>
<?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>


<div class="row">
<div class="col-md-6">


<div class="box box-primary">
<div class="box-header">
<div class="box-title">Main Setting</div>
</div>
<div class="box-body"><div class="course-update">



<div class="row">

<div class="col-md-6"><?= $form->field($model, 'course_code')->textInput(['maxlength' => true]) ?>
</div>

<div class="col-md-6"><?= $form->field($model, 'credit_hour')->textInput(['maxlength' => true]) ?></div>

</div>


<?= $form->field($model, 'course_name')->textInput(['maxlength' => true]) ?>
	<?= $form->field($model, 'course_name_bi')->textInput(['maxlength' => true]) ?>




</div></div>
</div>


<div class="box box-danger">
<div class="box-header">
<h3 class="box-title">Staff in Charge</h3>
</div>
<div class="box-body">

<?=$form->field($model, 'updated_at')->hiddenInput(['value' => time()])->label(false)?>

<?php DynamicFormWidget::begin([
        'widgetContainer' => 'dynamicform_wrapper',
        'widgetBody' => '.container-items',
        'widgetItem' => '.pic-item',
        'limit' => 10,
        'min' => 1,
        'insertButton' => '.add-pic',
        'deleteButton' => '.remove-pic',
        'model' => $pics[0],
        'formId' => 'dynamic-form',
        'formFields' => [
            'id',
            'staff_id',
        ],
    ]); ?>

    
    <table class="table table-bordered table-striped">

        <tbody class="container-items">
        <?php foreach ($pics as $i => $pic): ?>
            <tr class="pic-item">
            
                <td class="vcenter">
                    <?php
                        // necessary for update action.
                        if (! $pic->isNewRecord) {
                            echo Html::activeHiddenInput($pic, "[{$i}]id");
                        }
                    ?>
                    <?= $form->field($pic, "[{$i}]staff_id")->dropDownList(ArrayHelper::map(Staff::activeStaff(), 'id', 'user.fullname'), ['prompt' => 'Select'])->label(false) ?>
                </td>

                <td class="text-center vcenter" style="width: 40px;">
                    <button type="button" class="remove-pic btn btn-default btn-sm"><span class="fa fa-remove"></span></button>
                </td>
            </tr>
         <?php endforeach; ?>
        </tbody>
        
        <tfoot>
            <tr>
                <td>
                <button type="button" class="add-pic btn btn-default btn-sm"><span class="fa fa-plus"></span> New Staff in Charge</button>
                
                </td>
                <td>
                
                
                </td>
            </tr>
        </tfoot>
        
    </table>
    <?php DynamicFormWidget::end(); ?>


</div>
</div>


    <div class="form-group">
	<?= Html::a("<span class='glyphicon glyphicon-arrow-left'></span> BACK", ['course-admin/index'] ,['class' => 'btn btn-default']) ?>
        <?= Html::submitButton('<span class="glyphicon glyphicon-floppy-disk"></span> SAVE COURSE', ['class' => 'btn btn-success']) ?>
    </div>


</div>

<div class="col-md-6">

<div class="box box-info">
<div class="box-header">
<h3 class="box-title">FK01 - FK03</h3>
</div>
<div class="box-body">

<div class="table-responsive">
  <table class="table table-striped table-hover">
    <thead>
      <tr>
		<th>#</th>
        <th>Document</th>
        <th>PDF</th>
      </tr>
    </thead>
    <tbody>
      <tr>
		<td>1.</td>
        <td><span class="glyphicon glyphicon-file"></span> FK01 - PRO FORMA KURSUS / <i>COURSE PRO FORMA</i>                             </td>
        <td><a href="<?=Url::to(['/esiap/course/fk1', 'course' => $model->id])?>" class="btn btn-danger btn-sm" target="_blank"><span class='glyphicon glyphicon-download-alt'></span></a></td>
      </tr>
	  <tr>
	  <td>2.</td>
        <td><span class="glyphicon glyphicon-file"></span> FK02 - MAKLUMAT KURSUS / <i>COURSE INFORMATION </i>                               </td>
        <td><a href="<?=Url::to(['/esiap/course/fk2', 'course' => $model->id])?>" class="btn btn-danger btn-sm" target="_blank"><span class='glyphicon glyphicon-download-alt'></span></a></td>
      </tr>
	  <tr>
	  <td>3.</td>
        <td><span class="glyphicon glyphicon-file"></span> FK03 - PENJAJARAN KONSTRUKTIF / <i>CONSTRUCTIVE ALIGNMENT       </i>                         </td>
        <td><a href="<?=Url::to(['/esiap/course/fk3', 'course' => $model->id])?>" class="btn btn-danger btn-sm" target="_blank"><span class='glyphicon glyphicon-download-alt'></span></a></td>
      </tr>
      
    </tbody>
  </table>
</div>

</div>
</div>


<div class="box box-warning">
<div class="box-header">
<h3 class="box-title">Active Version</h3>
</div>
<div class="box-body">

<div class="table-responsive">
  <table class="table table-striped table-hover">
    <tbody>
      <tr>
        <td>Version Name</td>
        <td><?=$model->defaultVersion->version_name?></td>
      </tr>
	  <tr>
        <td>Status</td>
        <td><?=$model->defaultVersion->labelStatus?></td>
      </tr>
	  <tr>
        <td>Action</td>
        <td><?php 
		
		$status = $model->defaultVersion->status;
		if($status == 0){
			echo 'Waiting for submission';
		}else if($status == 10){
			echo '<a href="" class="btn btn-warning btn-sm">VERIFY</a>';
		}else if($status == 20){
			echo '<a href="" class="btn btn-default btn-sm">BACK TO DRAFT</a>';
		}
		
		
		?></td>
      </tr>
     <tr>
        <td><a class="btn btn-default btn-sm" href="<?=Url::to(['/esiap/course-admin/course-version', 'course' => $model->id])?>"><span class='glyphicon glyphicon-cog'></span> Manage Version</a></td>
        <td></td>
      </tr>
    </tbody>
  </table>
</div>

</div>
</div>


</div>

</div>





    <?php ActiveForm::end(); ?>