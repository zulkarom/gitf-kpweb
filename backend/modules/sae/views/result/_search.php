<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ResultSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="candidate-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'session_id') ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'auth_key') ?>

    <?= $form->field($model, 'matric_no') ?>

    <?php // echo $form->field($model, 'program') ?>

    <?php // echo $form->field($model, 'password_hash') ?>

    <?php // echo $form->field($model, 'password_reset_token') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'can_name') ?>

    <?php // echo $form->field($model, 'department') ?>

    <?php // echo $form->field($model, 'can_batch') ?>

    <?php // echo $form->field($model, 'can_zone') ?>

    <?php // echo $form->field($model, 'finished_at') ?>

    <?php // echo $form->field($model, 'answer_status') ?>

    <?php // echo $form->field($model, 'answer_status2') ?>

    <?php // echo $form->field($model, 'overall_status') ?>

    <?php // echo $form->field($model, 'answer_last_saved') ?>

    <?php // echo $form->field($model, 'question_last_saved') ?>

    <?php // echo $form->field($model, 'answer_last_saved2') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'verification_token') ?>

    <?php // echo $form->field($model, 'user_active') ?>

    <?php // echo $form->field($model, 'user_deleted') ?>

    <?php // echo $form->field($model, 'user_account_type') ?>

    <?php // echo $form->field($model, 'user_has_avatar') ?>

    <?php // echo $form->field($model, 'user_remember_me_token') ?>

    <?php // echo $form->field($model, 'user_creation_timestamp') ?>

    <?php // echo $form->field($model, 'user_suspension_timestamp') ?>

    <?php // echo $form->field($model, 'user_last_login_timestamp') ?>

    <?php // echo $form->field($model, 'user_failed_logins') ?>

    <?php // echo $form->field($model, 'user_last_failed_login') ?>

    <?php // echo $form->field($model, 'user_activation_hash') ?>

    <?php // echo $form->field($model, 'user_password_reset_hash') ?>

    <?php // echo $form->field($model, 'user_password_reset_timestamp') ?>

    <?php // echo $form->field($model, 'user_provider_type') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
