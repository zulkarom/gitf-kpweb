<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use backend\modules\staff\models\Staff;
use backend\modules\postgrad\models\External;
use backend\modules\postgrad\models\Field;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\Supervisor */
/* @var $form yii\widgets\ActiveForm */

$show_in = '';
$show_ex = 'style="display:none"';

if($model->isNewRecord){
    $model->is_internal = 1;
}

if($model->is_internal == 0){
    $show_in = 'style="display:none"';
    $show_ex = '';
}
?>

<div class="supervisor-form">

    <?php $form = ActiveForm::begin(); ?>
    
     <div class="box">
<div class="box-header"></div>
<div class="box-body">

<div class="row">
	<div class="col-md-6">
	<?= $form->field($model, 'is_internal')->dropDownList($model->listType()) ?>


 <div id="con_in" <?=$show_in?>>
 
 <?php 


echo $form->field($model, 'staff_id')->widget(Select2::classname(), [
    'data' => Staff::listAcademicStaffArray(),
    'options' => ['placeholder' => 'Select ..'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);

?>
 
 
 
 </div>

   <div id="con_ex" <?=$show_ex?>> 
   
   
    <?php 


echo $form->field($model, 'external_id')->widget(Select2::classname(), [
    'data' => External::listExternalArray(),
    'options' => ['placeholder' => 'Select ..'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);

?>
   
   
   </div>
   
   
       <?php 

$model->fields = $model->getSvFieldsArray();
echo $form->field($model, 'fields')->widget(Select2::classname(), [
    'data' => Field::listFieldArray(),
    'options' => ['multiple' => true, 'placeholder' => 'Select ..'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);

?>



	
	
	</div>
	<div class="col-md-6"></div>
</div>




</div>
</div>

   

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>



<?php 


$this->registerJs(' 

$("#supervisor-is_internal").change(function(){
    //alert(123);
    var val = $(this).val();
    if(val == 1){
        $("#con_in").slideDown();
        $("#con_ex").slideUp();
    }else{
        $("#con_in").slideUp();
        $("#con_ex").slideDown();
    }
});


');



?>
