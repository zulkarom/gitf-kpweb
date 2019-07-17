<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\staff\models\Staff */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="staff-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'staff_no')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_password_hash')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'staff_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'staff_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'staff_name_pub')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'staff_title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'staff_edu')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_academic')->textInput() ?>

    <?= $form->field($model, 'position_id')->textInput() ?>

    <?= $form->field($model, 'position_status')->textInput() ?>

    <?= $form->field($model, 'working_status')->textInput() ?>

    <?= $form->field($model, 'leave_start')->textInput() ?>

    <?= $form->field($model, 'leave_end')->textInput() ?>

    <?= $form->field($model, 'leave_note')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'rotation_post')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'staff_expertise')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'staff_gscholar')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'officephone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'handphone1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'handphone2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'staff_ic')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'staff_dob')->textInput() ?>

    <?= $form->field($model, 'date_begin_umk')->textInput() ?>

    <?= $form->field($model, 'date_begin_service')->textInput() ?>

    <?= $form->field($model, 'staff_note')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'personal_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ofis_location')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'staff_cv')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'staff_img')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'teach_pg')->textInput() ?>

    <?= $form->field($model, 'staff_level')->textInput() ?>

    <?= $form->field($model, 'staff_interest')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'staff_department')->textInput() ?>

    <?= $form->field($model, 'is_super')->textInput() ?>

    <?= $form->field($model, 'progress')->textInput() ?>

    <?= $form->field($model, 'total_progress')->textInput() ?>

    <?= $form->field($model, 'trash')->textInput() ?>

    <?= $form->field($model, 'publish')->textInput() ?>

    <?= $form->field($model, 'user_active')->textInput() ?>

    <?= $form->field($model, 'user_deleted')->textInput() ?>

    <?= $form->field($model, 'user_account_type')->textInput() ?>

    <?= $form->field($model, 'user_suspension_timestamp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_last_login_timestamp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_failed_logins')->textInput() ?>

    <?= $form->field($model, 'user_last_failed_login')->textInput() ?>

    <?= $form->field($model, 'user_password_reset_hash')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'user_password_reset_timestamp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'session_id')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
