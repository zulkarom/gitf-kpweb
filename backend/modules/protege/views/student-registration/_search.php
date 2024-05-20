<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\protege\models\StudentRegistrationSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="student-registration-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'company_offer_id') ?>

    <?= $form->field($model, 'student_matric') ?>

    <?= $form->field($model, 'student_name') ?>

    <?php // echo $form->field($model, 'program_abbr') ?>

    <?php // echo $form->field($model, 'register_at') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
