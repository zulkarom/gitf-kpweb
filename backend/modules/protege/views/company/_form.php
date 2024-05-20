<?php

use kartik\form\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\protege\models\Company */
/* @var $form yii\widgets\ActiveForm */
if($model->isNewRecord){
    $model->status = 10;
}
?>

<div class="box">
<div class="box-header">
</div>
<div class="box-body">
<div class="company-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'company_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'address')->textarea(['rows' => 3]) ?>
    <?= $form->field($model, 'company_pic')->textInput(['maxlength' => true]) ?>
    <div class="row">
        <div class="col-md-6"><?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?></div>
        <div class="col-md-6"> <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?></div>
    </div>
    
   

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status')->dropDownList($model->statusArray, ['prompt' => 'Select Status']) ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div></div>
