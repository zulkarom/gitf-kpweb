<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\UniversitySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="university-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'uni_name') ?>

    <?= $form->field($model, 'uni_name_en') ?>

    <?= $form->field($model, 'uni_abbr') ?>

    <?= $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'thrust') ?>

    <?php // echo $form->field($model, 'main_location') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
