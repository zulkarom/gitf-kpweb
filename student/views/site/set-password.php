<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model student\models\forms\SetPasswordForm */

$this->title = 'Set New Password';
?>
<div class="login-box-body">
    <p class="login-box-msg">Create your new password</p>

    <?php $form = ActiveForm::begin(['id' => 'set-password-form']); ?>

        <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'New Password']) ?>

        <?= $form->field($model, 'password_confirm')->passwordInput(['placeholder' => 'Confirm Password']) ?>

        <div class="row">
            <div class="col-xs-8">
                <a href="<?= yii\helpers\Url::to(['/site/login']) ?>">Back to Sign In</a>
            </div>
            <div class="col-xs-4">
                <?= Html::submitButton('Save Password', ['class' => 'btn btn-primary btn-block btn-flat']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>
</div>
