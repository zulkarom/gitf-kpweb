<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\protege\models\CompanyOffer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box">
<div class="box-header">
</div>
<div class="box-body">

<div class="company-offer-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'available_slot')->textInput() ?>
    <?= $form->field($model, 'is_published')->dropDownList($model->publishArray) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

</div></div>
