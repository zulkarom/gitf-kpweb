<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\courseFiles\models\Material */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box">
<div class="box-header"></div>
<div class="box-body"><div class="material-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'material_name')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($model, 'mt_type')->dropDownList(
	    [
	        1=> 'For Course File', 
	        2 => 'For Other Purposes'], ['prompt' => 'Please Select']
	    ) ?>
	    
	    <i>* e.g. Material group name: 'Teaching Slides Semester Feb 2020/2021', 'Teaching Materials 2021', 'Teaching Reference' etc.</i> <br />
	   <i>** Select type 'For Course File' if you want to put it in your course file.</i> 
<br /><br />

    <div class="form-group">
        <?= Html::submitButton('Create Material Group', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
