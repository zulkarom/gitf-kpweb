<?php

use kartik\form\ActiveForm;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\protege\models\Session */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box">
<div class="box-header">
</div>
<div class="box-body">

<div class="session-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'session_name')->textInput(['maxlength' => true]) ?>

    <div class="row">
        <div class="col-md-6"><?= $form->field($model, 'total_student')->textInput(['maxlength' => true]) ?></div>
        <div class="col-md-6"><?= $form->field($model, 'is_active')->dropDownList($model->activeArray)?></div>
    </div>
    
    

    <?= $form->field($model, 'instruction')->textarea(['row' => 4])?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

</div></div>


