<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\erpd\models\PublicationSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="publication-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'pub_id') ?>

    <?= $form->field($model, 'staff_id') ?>

    <?= $form->field($model, 'pub_type') ?>

    <?= $form->field($model, 'pub_year') ?>

    <?= $form->field($model, 'pub_title') ?>

    <?php // echo $form->field($model, 'pub_journal') ?>

    <?php // echo $form->field($model, 'pub_volume') ?>

    <?php // echo $form->field($model, 'pub_issue') ?>

    <?php // echo $form->field($model, 'pub_page') ?>

    <?php // echo $form->field($model, 'pub_city') ?>

    <?php // echo $form->field($model, 'pub_state') ?>

    <?php // echo $form->field($model, 'pub_publisher') ?>

    <?php // echo $form->field($model, 'pub_isbn') ?>

    <?php // echo $form->field($model, 'pub_organizer') ?>

    <?php // echo $form->field($model, 'pub_inbook') ?>

    <?php // echo $form->field($model, 'pub_month') ?>

    <?php // echo $form->field($model, 'pub_day') ?>

    <?php // echo $form->field($model, 'pub_date') ?>

    <?php // echo $form->field($model, 'pub_index') ?>

    <?php // echo $form->field($model, 'has_file') ?>

    <?php // echo $form->field($model, 'file_name') ?>

    <?php // echo $form->field($model, 'modified_at') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
