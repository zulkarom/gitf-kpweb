<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\Module */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="module-form">

    <?php $form = ActiveForm::begin(); ?>
    
    
     <div class="box">
<div class="box-header"></div>
<div class="box-body">

    <div class="row">
	<div class="col-md-6">    
	
	
	<?= $form->field($model, 'module_name')->textInput(['maxlength' => true]) ?></div>
</div>

</div>
</div>
    
    
    
    





    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
