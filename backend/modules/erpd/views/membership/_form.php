<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\modules\erpd\models\Membership */
/* @var $form yii\widgets\ActiveForm */
?>
    <?php $form = ActiveForm::begin(); ?>
<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="membership-form">


	
	<div class="row">
<div class="col-md-8"> <?= $form->field($model, 'msp_body')->dropDownList($model->membershipBodySample()) ?></div>



</div>

<div class="row">
<div class="col-md-4"><?= $form->field($model, 'msp_type')->dropDownList($model->membershipTypeSample()) ?>
</div>

</div>




   
<div class="row">


<div class="col-md-2">



 <?=$form->field($model, 'date_start')->widget(DatePicker::classname(), [
    'removeButton' => false,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
        
    ],
    
    
]);
?>


</div>
<div class="col-md-2">
 <?=$form->field($model, 'date_end')->widget(DatePicker::classname(), [
    'removeButton' => false,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
        
    ],
    
    
]);
?>

</div>

</div>

<div class="row">
<div class="col-md-6"><?= $form->field($model, 'msp_level')->dropDownList( $model->listLevel() ) ?></div>

</div>
    



   

</div></div>
</div>

    <div class="form-group">
        <?= Html::submitButton('Save as Draft', ['class' => 'btn btn-success']) ?>
    </div>

 <?php ActiveForm::end(); ?>