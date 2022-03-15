<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\External */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="external-form">

    <?php $form = ActiveForm::begin(); ?>
    
     <div class="box">
<div class="box-header"></div>
<div class="box-body">


<div class="row">
	<div class="col-md-6">
	
	  <?= $form->field($model, 'ex_name')->textInput(['maxlength' => true]) ?>

    <?php 


echo $form->field($model, 'university_id')->widget(Select2::classname(), [
    'data' => $model->universityList(),
    'options' => ['placeholder' => 'Select ...'],
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
