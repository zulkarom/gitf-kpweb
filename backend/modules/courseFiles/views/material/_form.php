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
	
	<?= $form->field($model, 'mt_type')->dropDownList([1=> 'For Course File (pdf only)', 2 => 'Others (pdf,doc,docx,ppt,pptx,txt)'], ['prompt' => 'Please Select']) ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
</div>
