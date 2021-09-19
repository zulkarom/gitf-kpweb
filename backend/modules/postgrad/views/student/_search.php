<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\postgrad\models\StudentPostGradSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="student-post-grad-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'matric_no') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'nric') ?>

    <?= $form->field($model, 'date_birth') ?>

    <?php // echo $form->field($model, 'gender') ?>

    <?php // echo $form->field($model, 'marital_status') ?>

    <?php // echo $form->field($model, 'nationality') ?>

    <?php // echo $form->field($model, 'citizenship') ?>

    <?php // echo $form->field($model, 'prog_code') ?>

    <?php // echo $form->field($model, 'edu_level') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'city') ?>

    <?php // echo $form->field($model, 'phone_no') ?>

    <?php // echo $form->field($model, 'personal_email') ?>

    <?php // echo $form->field($model, 'student_email') ?>

    <?php // echo $form->field($model, 'religion') ?>

    <?php // echo $form->field($model, 'race') ?>

    <?php // echo $form->field($model, 'bachelor_name') ?>

    <?php // echo $form->field($model, 'university_name') ?>

    <?php // echo $form->field($model, 'bachelor_cgpa') ?>

    <?php // echo $form->field($model, 'bachelor_year') ?>

    <?php // echo $form->field($model, 'session') ?>

    <?php // echo $form->field($model, 'admission_year') ?>

    <?php // echo $form->field($model, 'admission_date_sem1') ?>

    <?php // echo $form->field($model, 'sponsor') ?>

    <?php // echo $form->field($model, 'student_current_sem') ?>

    <?php // echo $form->field($model, 'city_campus') ?>

    <?php // echo $form->field($model, 'student_status') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
