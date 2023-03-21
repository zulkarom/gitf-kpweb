<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use common\models\UploadFile;

/* @var $this yii\web\View */
/* @var $model backend\modules\proceedings\models\Proceeding */
/* @var $form yii\widgets\ActiveForm */

$model->file_controller = 'default';
?>

  <div class="box">
    <div class="box-header">
    </div>      
<div class="box-body">


<div class="proceeding-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'proc_name')->textInput(['maxlength' => true]) ?>
	
	 <?= $form->field($model, 'proc_url')->textInput(['maxlength' => true]) ?>

  

 <?=$form->field($model, 'date_start')->widget(DatePicker::classname(), [
    'removeButton' => false,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
        
    ],
    
    
]);
?>


    <?=$form->field($model, 'date_end')->widget(DatePicker::classname(), [
    'removeButton' => false,
    'pluginOptions' => [
        'autoclose'=>true,
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
        
    ],
    
    
]);
?>

	
	<?=UploadFile::fileInput($model, 'image', true)?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


</div>
    </div>


