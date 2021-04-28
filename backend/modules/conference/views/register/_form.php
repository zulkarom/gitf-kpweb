<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\conference\models\ConfRegistration */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="conf-registration-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'conf_id')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'reg_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
