<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\Kursus */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kursus-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'kursus_name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save Kursus', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
