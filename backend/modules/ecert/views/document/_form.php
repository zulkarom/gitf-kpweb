<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\ecert\models\Document */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="document-form">


 <div class="box">
<div class="box-header"></div>
<div class="box-body">


<div class="row">
	<div class="col-md-6">

	 <?php

$form = ActiveForm::begin();
?>

    <?=$form->field($model, 'identifier')->textInput()?>

    <?=$form->field($model, 'participant_name')->textInput(['maxlength' => true])?>

    <?=$form->field($model, 'field1')->textInput(['maxlength' => true])?>

    <?=$form->field($model, 'field2')->textInput(['maxlength' => true])?>

    <?=$form->field($model, 'field3')->textInput(['maxlength' => true])?>

    <?=$form->field($model, 'field4')->textInput(['maxlength' => true])?>

    <?=$form->field($model, 'field5')->textInput(['maxlength' => true])?>


    <div class="form-group">
        <?=Html::submitButton('Save', ['class' => 'btn btn-success'])?>
    </div>

    <?php

    ActiveForm::end();
    ?>

	</div>

</div>


</div>
</div>




</div>
