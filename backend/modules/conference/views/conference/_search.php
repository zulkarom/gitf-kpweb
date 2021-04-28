<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\conference\models\ConferenceSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="conference-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'conf_name') ?>

    <?= $form->field($model, 'conf_abbr') ?>

    <?= $form->field($model, 'conf_date') ?>

    <?= $form->field($model, 'conf_venue') ?>

    <?php // echo $form->field($model, 'conf_url') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
