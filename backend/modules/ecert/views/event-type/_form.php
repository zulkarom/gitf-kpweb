<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\ecert\models\EventType */
/* @var $form yii\widgets\ActiveForm */
?>

 <div class="box">
<div class="box-header"></div>
<div class="box-body">

<div class="event-type-form">

<div class="row">
	<div class="col-md-6">

	  <?php

$form = ActiveForm::begin();
?>

    <?=$form->field($model, 'type_name')->textInput(['maxlength' => true])?>

    <?=$form->field($model, 'field1_mt')->textInput()?>

    <?=$form->field($model, 'field1_size')->textInput()?>

    <?=$form->field($model, 'field2_mt')->textInput()?>

    <?=$form->field($model, 'field2_size')->textInput()?>

    <?=$form->field($model, 'field3_mt')->textInput()?>

    <?=$form->field($model, 'field3_size')->textInput()?>

    <?=$form->field($model, 'field4_mt')->textInput()?>

    <?=$form->field($model, 'field4_size')->textInput()?>

    <?=$form->field($model, 'field5_mt')->textInput()?>

    <?=$form->field($model, 'field5_size')->textInput()?>

    <?=$form->field($model, 'margin_right')->textInput()?>

    <?=$form->field($model, 'margin_left')->textInput()?>
    <?=$form->field($model, 'is_portrait')->dropDownList([1 => 'Yes',0 => 'No'])?>

    <?php
    if ($model->isNewRecord) {
        $model->set_type = 1;
    }

    ?>

    <?=$form->field($model, 'set_type')->textInput()?>

    <?=$form->field($model, 'custom_html')->textarea(['rows' => 6])?>

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


