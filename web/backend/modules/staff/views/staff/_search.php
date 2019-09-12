<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\staff\models\StaffSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="staff-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'staff_id') ?>

    <?= $form->field($model, 'staff_no') ?>

    <?= $form->field($model, 'user_name') ?>

    <?= $form->field($model, 'user_password_hash') ?>

    <?= $form->field($model, 'staff_email') ?>

    <?php // echo $form->field($model, 'staff_name') ?>

    <?php // echo $form->field($model, 'staff_name_pub') ?>

    <?php // echo $form->field($model, 'staff_title') ?>

    <?php // echo $form->field($model, 'staff_edu') ?>

    <?php // echo $form->field($model, 'is_academic') ?>

    <?php // echo $form->field($model, 'position_id') ?>

    <?php // echo $form->field($model, 'position_status') ?>

    <?php // echo $form->field($model, 'working_status') ?>

    <?php // echo $form->field($model, 'leave_start') ?>

    <?php // echo $form->field($model, 'leave_end') ?>

    <?php // echo $form->field($model, 'leave_note') ?>

    <?php // echo $form->field($model, 'rotation_post') ?>

    <?php // echo $form->field($model, 'staff_expertise') ?>

    <?php // echo $form->field($model, 'staff_gscholar') ?>

    <?php // echo $form->field($model, 'officephone') ?>

    <?php // echo $form->field($model, 'handphone1') ?>

    <?php // echo $form->field($model, 'handphone2') ?>

    <?php // echo $form->field($model, 'staff_ic') ?>

    <?php // echo $form->field($model, 'staff_dob') ?>

    <?php // echo $form->field($model, 'date_begin_umk') ?>

    <?php // echo $form->field($model, 'date_begin_service') ?>

    <?php // echo $form->field($model, 'staff_note') ?>

    <?php // echo $form->field($model, 'personal_email') ?>

    <?php // echo $form->field($model, 'ofis_location') ?>

    <?php // echo $form->field($model, 'staff_cv') ?>

    <?php // echo $form->field($model, 'staff_img') ?>

    <?php // echo $form->field($model, 'teach_pg') ?>

    <?php // echo $form->field($model, 'staff_level') ?>

    <?php // echo $form->field($model, 'staff_interest') ?>

    <?php // echo $form->field($model, 'staff_department') ?>

    <?php // echo $form->field($model, 'is_super') ?>

    <?php // echo $form->field($model, 'progress') ?>

    <?php // echo $form->field($model, 'total_progress') ?>

    <?php // echo $form->field($model, 'trash') ?>

    <?php // echo $form->field($model, 'publish') ?>

    <?php // echo $form->field($model, 'user_active') ?>

    <?php // echo $form->field($model, 'user_deleted') ?>

    <?php // echo $form->field($model, 'user_account_type') ?>

    <?php // echo $form->field($model, 'user_suspension_timestamp') ?>

    <?php // echo $form->field($model, 'user_last_login_timestamp') ?>

    <?php // echo $form->field($model, 'user_failed_logins') ?>

    <?php // echo $form->field($model, 'user_last_failed_login') ?>

    <?php // echo $form->field($model, 'user_password_reset_hash') ?>

    <?php // echo $form->field($model, 'user_password_reset_timestamp') ?>

    <?php // echo $form->field($model, 'session_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
