<?php

use yii\helpers\Html;
use backend\models\Semester;
use kartik\date\DatePicker;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\StudentSemester */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="student-semester-form">

    <?php $form = ActiveForm::begin(); ?>
    
    
    <div class="box">
<div class="box-header"></div>
<div class="box-body">


<div class="row">
    <div class="col-md-6">
    
    
    <?= $form->field($model, 'semester_id')->dropDownList(Semester::listSemesterArray(), ['prompt' => 'Select..']) ?>

 <?=$form->field($model, 'date_register')->widget(DatePicker::classname(), [
    'removeButton' => false,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
        
    ],
    
    
]);
?>

    <?= $form->field($model, 'status')->dropDownList($model->statusList()) ?>



<?= $form->field($model, 'fee_amount', [
    'addon' => ['prepend' => ['content'=> 'RM']]
]); ?>
    

    
     <?=$form->field($model, 'fee_paid_at')->widget(DatePicker::classname(), [
    'removeButton' => false,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
        
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
