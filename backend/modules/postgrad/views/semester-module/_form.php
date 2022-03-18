<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use backend\modules\esiap\models\Course;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\SemesterModule */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="semester-module-form">

    <?php $form = ActiveForm::begin(); ?>
    
    
     <div class="box">
<div class="box-header"></div>
<div class="box-body">

    <div class="row">
	<div class="col-md-6">
	
	
	
	<?php 


echo $form->field($model, 'module_id')->widget(Select2::classname(), [
    'data' => Course::activeCoursesPgArray(),
    'options' => ['placeholder' => 'Select...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);

?>
	
	
	<?= $form->field($model, 'result')->dropDownList($model->resultList(), ['prompt' => 'Select']) ?>
	
	
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
