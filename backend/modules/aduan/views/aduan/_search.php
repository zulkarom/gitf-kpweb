<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\aduan\models\AduanSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="aduan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'nric') ?>

    <?= $form->field($model, 'address') ?>

    <?= $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'topic') ?>

    <?php // echo $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'aduan') ?>

    <?php // echo $form->field($model, 'declaration') ?>

    <?php // echo $form->field($model, 'upload_url') ?>

    <?php // echo $form->field($model, 'captcha') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
